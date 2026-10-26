<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cambre\Vw_orden_mecanizado;

class OrdenMecanizadoTabla
{
    public function respuesta(Request $request)
    {
        $request->validate([            'draw' => 'required|integer|min:0', 'start' => 'required|integer|min:0',
            'length' => 'required|integer|between:1,500',
            'search.value' => 'nullable|string|max:500', 'order' => 'sometimes|array|max:10',
            'order.*.column' => 'required|integer|between:0,14', 'order.*.dir' => 'required|in:asc,desc',
            'filtrosCabecera' => 'required|json',
        ]);
        $base = Vw_orden_mecanizado::from('vw_orden_mecanizado as v');
        $hdr = "EXISTS(SELECT 1 FROM orden_mecanizado mec JOIN hoja_de_ruta hdr ON hdr.id_orden_mecanizado = mec.id_orden_mecanizado WHERE mec.id_orden = v.id_orden)";
        $campos = [1 => 'v.prioridad_servicio', 2 => 'v.codigo_servicio', 4 => 'v.nombre_orden',
            5 => 'v.manufactura', 6 => "CONCAT(COALESCE(v.total_ope_completo, 0), '/', COALESCE(v.total_ope, 0))",
            7 => 'v.nombre_estado', 8 => 'v.ope_act', 9 => 'v.nom_est_ope_act', 10 => 'v.fecha_limite',
            11 => 'v.total_horas_hdr', 12 => 'v.cantidad', 13 => 'v.responsable'];
        $columnas = [];
        foreach ($campos as $indice => $campo) {
            $valor = $campo;
            $defecto = $campo === 'v.prioridad_servicio' ? 'S/P' : ($campo === 'v.total_horas_hdr' ? '00:00' : '-');
            $columnas[$indice] = "CONVERT(COALESCE(".$valor.", '".$defecto."') USING utf8mb4) COLLATE utf8mb4_unicode_ci";
        }
        $total = (clone $base)->count();
        $consulta = clone $base;
        if ($request->boolean('sinHdr')) $consulta->whereRaw('NOT '.$hdr);
        $filtros = json_decode($request->input('filtrosCabecera'), true);
        validator(['filtros' => $filtros], ['filtros' => 'array', 'filtros.*' => 'array',
            'filtros.*.incluir' => 'sometimes|array', 'filtros.*.incluir.*' => 'string',
            'filtros.*.excluir' => 'sometimes|array', 'filtros.*.excluir.*' => 'string'])->validate();
        foreach ($filtros as $indice => $filtro) {
            if (!isset($columnas[$indice])) continue;
            if (isset($filtro['incluir'])) $consulta->whereIn(DB::raw($columnas[$indice]), $filtro['incluir']);
            if (isset($filtro['excluir'])) $consulta->whereNotIn(DB::raw($columnas[$indice]), $filtro['excluir']);
        }
        $buscar = trim($request->input('search.value', ''));
        if ($buscar !== '') foreach (preg_split('/\s+/u', $buscar) as $termino) {
            $consulta->where(function ($q) use ($columnas, $termino) {
                foreach ($columnas as $columna) $q->orWhereRaw($columna.' LIKE ?', ['%'.$termino.'%']);
            });
        }
        $filtrados = empty($filtros) && $buscar === '' && !$request->boolean('sinHdr') ? $total : (clone $consulta)->count();
        foreach ($request->input('order', []) as $orden) {
            $indice = (int) $orden['column'];
            if (!isset($columnas[$indice])) continue;
            if ($indice === 1) {
                // Missing priorities stay last in either direction; compare priorities as numbers.
                $consulta->orderByRaw("CASE WHEN v.prioridad_servicio IS NULL OR TRIM(v.prioridad_servicio) = '' THEN 1 ELSE 0 END ASC")
                    ->orderByRaw('CAST(v.prioridad_servicio AS DECIMAL(20, 6)) '.$orden['dir']);
                continue;
            }
            $campo = $campos[$indice];
            $consulta->orderByRaw(($indice === 6 ? '(COALESCE(v.total_ope_completo, 0) / NULLIF(v.total_ope, 0))' : $campo).' '.$orden['dir']);
        }
        // Paginate identifiers before evaluating the expensive calculated fields of the view.
        $ids = $consulta->orderBy('v.id_orden')->offset((int) $request->input('start'))
            ->limit((int) $request->input('length'))->pluck('v.id_orden')->all();
        $filas = (clone $base)->whereIn('v.id_orden', $ids)->get([
                'v.id_orden', 'v.prioridad_servicio', 'v.codigo_servicio', 'v.nombre_servicio',
                'v.nombre_orden', 'v.descripcion_etapa', 'v.manufactura', 'v.total_ope', 'v.total_ope_completo',
                'v.nombre_estado', 'v.id_estado_mecanizado', 'v.ope_act', 'v.nom_est_ope_act',
                'v.fecha_limite', 'v.total_horas_hdr', 'v.cantidad', 'v.responsable'
            ]);
        $posiciones = array_flip($ids);
        $filas = $filas->sortBy(function ($orden) use ($posiciones) { return $posiciones[$orden->id_orden]; })->values();
        $datos = $filas->map(function ($orden) {
            $html = view('Ingenieria.Servicios.Ordenes.mecanizado.fila-tabla', ['orden' => $orden, 'tipo_orden' => 3])->render();
            preg_match_all('/<td\b[^>]*>(.*?)<\/td>/s', $html, $celdas);
            if (count($celdas[1]) !== 15) throw new \RuntimeException('Cantidad de columnas incorrecta en mecanizado');
            return ['id' => $orden->id_orden, 'celdas' => array_map('trim', $celdas[1])];
        });
        $respuesta = ['draw' => (int) $request->input('draw'), 'recordsTotal' => $total,
            'recordsFiltered' => $filtrados, 'data' => $datos->values()];
        if ($request->boolean('opcionesFiltros')) {
            // Read the filter values together: each separate DISTINCT would rebuild the SQL view.
            $seleccion = [];
            foreach ($columnas as $indice => $columna) {
                $seleccion[] = $columna.' as filtro_'.$indice;
            }
            $valores = (clone $base)->selectRaw(implode(', ', $seleccion))->toBase()->get();
            $respuesta['opcionesFiltros'] = [];
            foreach ($columnas as $indice => $columna) {
                $respuesta['opcionesFiltros'][$indice] = $valores->pluck('filtro_'.$indice)
                    ->map(function ($valor) { return (string) $valor; })
                    ->unique()->sort(SORT_STRING)->values();
            }

        }
        return response()->json($respuesta);
    }
}
