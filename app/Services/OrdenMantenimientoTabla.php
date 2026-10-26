<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cambre\Vw_orden_mantenimiento;

class OrdenMantenimientoTabla
{
    public function respuesta(Request $request)
    {
        $request->validate([            'draw' => 'required|integer|min:0', 'start' => 'required|integer|min:0',
            'length' => 'required|integer|between:1,500',
            'search.value' => 'nullable|string|max:500', 'order' => 'sometimes|array|max:10',
            'order.*.column' => 'required|integer|between:0,10', 'order.*.dir' => 'required|in:asc,desc',
            'filtrosCabecera' => 'required|json',
        ]);
        $horas = DB::table('parte')->groupBy('id_orden')
            ->selectRaw("id_orden, TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(horas))), '%H:%i') as total");
        $base = Vw_orden_mantenimiento::from('vw_orden_mantenimiento as v')
            ->leftJoinSub($horas, 'horas', function ($join) { $join->on('horas.id_orden', '=', 'v.id_orden'); });
        if (!\Illuminate\Support\Facades\Auth::user()->hasAnyRole(['ADMIN', 'SUPERVISOR'])) {
            $base->where('v.id_empleado_asignado', \Illuminate\Support\Facades\Auth::user()->getEmpleado->id_empleado);
        }
        $campos = [0 => 'v.prioridad_servicio', 1 => 'v.codigo_servicio', 3 => 'v.nombre_orden',
            4 => 'v.nombre_tipo_orden_mantenimiento', 5 => 'v.codigo_activo', 6 => 'v.nombre_estado',
            7 => 'v.nombre_empleado_asignado', 8 => 'horas.total', 9 => 'v.fecha_finalizacion'];
        $columnas = [];
        foreach ($campos as $indice => $campo) {
            $valor = $campo;
            $defecto = $campo === 'v.prioridad_servicio' ? 'S/P' : ($campo === 'v.total_horas_hdr' ? '00:00' : '-');
            $columnas[$indice] = "CONVERT(COALESCE(".$valor.", '".$defecto."') USING utf8mb4) COLLATE utf8mb4_unicode_ci";
        }
        $total = (clone $base)->count();
        $consulta = clone $base;
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
        $filtrados = empty($filtros) && $buscar === '' ? $total : (clone $consulta)->count();
        foreach ($request->input('order', []) as $orden) {
            $indice = (int) $orden['column'];
            if (!isset($columnas[$indice])) continue;
            if ($indice === 0) {
                // Missing priorities stay last in either direction; compare priorities as numbers.
                $consulta->orderByRaw("CASE WHEN v.prioridad_servicio IS NULL OR TRIM(v.prioridad_servicio) = '' THEN 1 ELSE 0 END ASC")
                    ->orderByRaw('CAST(v.prioridad_servicio AS DECIMAL(20, 6)) '.$orden['dir']);
                continue;
            }
            $campo = $campos[$indice];
            $consulta->orderByRaw($campo.' '.$orden['dir']);
        }
        // Paginate identifiers before evaluating the expensive calculated fields of the view.
        $ids = $consulta->orderBy('v.id_orden')->offset((int) $request->input('start'))
            ->limit((int) $request->input('length'))->pluck('v.id_orden')->all();
        $filas = (clone $base)->whereIn('v.id_orden', $ids)->get(['v.*', 'horas.total as horas']);
        $posiciones = array_flip($ids);
        $filas = $filas->sortBy(function ($orden) use ($posiciones) { return $posiciones[$orden->id_orden]; })->values();
        $datos = $filas->map(function ($orden) {
            $html = view('Ingenieria.Servicios.Ordenes.mantenimiento.fila-tabla', ['orden' => $orden])->render();
            preg_match_all('/<td\b[^>]*>(.*?)<\/td>/s', $html, $celdas);
            if (count($celdas[1]) !== 11) throw new \RuntimeException('Cantidad de columnas incorrecta en mantenimiento');
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
