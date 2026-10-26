<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cambre\Vw_orden_manufactura;

class OrdenManufacturaTabla
{
    public function respuesta(Request $request)
    {
        $request->validate([            'draw' => 'required|integer|min:0', 'start' => 'required|integer|min:0',
            'length' => 'required|integer|between:1,500',
            'search.value' => 'nullable|string|max:500', 'order' => 'sometimes|array|max:10',
            'order.*.column' => 'required|integer|between:0,13', 'order.*.dir' => 'required|in:asc,desc',
            'filtrosCabecera' => 'required|json',
        ]);
        // Only the first assembly operation and its activation part define the current assignment.
        $operaciones = DB::table('operaciones_de_hdr')->whereNotNull('id_orden_manufactura')
            ->groupBy('id_orden_manufactura')->selectRaw('id_orden_manufactura, MIN(id_ope_de_hdr) as id_ope');
        $partes = DB::table('parte_ope_hdr')
            ->where('observaciones', 'Se activo la operacion para el ensamblado de la orden de manufactura.')
            ->groupBy('id_ope_de_hdr')->selectRaw('id_ope_de_hdr, MIN(id_parte_ope_hdr) as id_parte');
        $base = Vw_orden_manufactura::from('vw_orden_manufactura as v')
            ->join('orden_manufactura as man', 'man.id_orden', '=', 'v.id_orden')
            ->leftJoinSub($operaciones, 'primera_ope', function ($join) { $join->on('primera_ope.id_orden_manufactura', '=', 'man.id_orden_manufactura'); })
            ->leftJoin('operaciones_de_hdr as ope', 'ope.id_ope_de_hdr', '=', 'primera_ope.id_ope')
            ->leftJoinSub($partes, 'primer_parte', function ($join) { $join->on('primer_parte.id_ope_de_hdr', '=', 'ope.id_ope_de_hdr'); })
            ->leftJoin('parte_ope_hdr as parte', 'parte.id_parte_ope_hdr', '=', 'primer_parte.id_parte')
            ->leftJoin('responsabilidad as res', 'res.id_responsabilidad', '=', 'parte.id_responsabilidad')
            ->leftJoin('empleado as emp', 'emp.id_empleado', '=', 'res.id_empleado');
        $campos = [1 => 'v.prioridad_servicio', 2 => 'v.codigo_servicio', 4 => 'v.nombre_orden',
            5 => 'v.descripcion_etapa', 6 => "CONCAT(COALESCE(v.tot_mec_completo, 0), ' / ', COALESCE(v.tot_mec, 0))",
            7 => 'v.nombre_estado', 8 => 'v.supervisor', 9 => 'v.total_horas', 10 => 'v.fecha_limite',
            11 => "CASE WHEN ope.activo = 1 THEN 'SI' ELSE 'NO' END", 12 => "COALESCE(emp.nombre_empleado, '')"];
        $columnas = [];
        foreach ($campos as $indice => $campo) {
            $valor = $campo === 'v.total_horas' ? "TIME_FORMAT(v.total_horas, '%H:%i')" : $campo;
            $defecto = $campo === 'v.prioridad_servicio' ? 'S/P' : '-';
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
            $campo = $campos[$indice];
            $consulta->orderByRaw(($indice === 6 ? 'v.tot_mec_porcentaje' : $campo).' '.$orden['dir']);
        }
        $filas = $consulta->orderBy('v.id_orden')->offset((int) $request->input('start'))
            ->limit((int) $request->input('length'))->get([
                'v.*', 'man.id_orden_manufactura as id_manufactura_tabla', 'ope.activo as activo_tabla',
                DB::raw("COALESCE(emp.nombre_empleado, '') as asignado_tabla"),
                DB::raw('ope.id_ope_de_hdr IS NOT NULL as posee_ensamblado'),
                DB::raw('EXISTS(SELECT 1 FROM orden_mecanizado mec WHERE mec.id_orden_manufactura = man.id_orden_manufactura) as tiene_mecanizados')
            ]);
        $datos = $filas->map(function ($orden) {
            $html = view('Ingenieria.Servicios.Ordenes.manufactura.fila-tabla', ['orden' => $orden, 'tipo_orden' => 2])->render();
            preg_match_all('/<td\b[^>]*>(.*?)<\/td>/s', $html, $celdas);
            if (count($celdas[1]) !== 14) throw new \RuntimeException('Cantidad de columnas incorrecta en manufactura');
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
