<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cambre\Vw_orden_trabajo;
use Illuminate\Support\Facades\Auth;

class OrdenTrabajoTabla
{
    public function respuesta(Request $request)
    {
        $request->validate([            'draw' => 'required|integer|min:0', 'start' => 'required|integer|min:0',
            'length' => 'required|integer|between:1,500',
            'search.value' => 'nullable|string|max:500', 'order' => 'sometimes|array|max:10',
            'order.*.column' => 'required|integer|between:0,12', 'order.*.dir' => 'required|in:asc,desc',
            'filtrosCabecera' => 'required|json',
        ]);
        $base = Vw_orden_trabajo::query();
        if (!Auth::user()->hasAnyRole(['SUPERVISOR', 'ADMIN'])) {
            $base->responsable(Auth::user()->getEmpleado->id_empleado);
        }
        $campos = [1 => 'prioridad_servicio', 2 => 'codigo_servicio', 4 => 'nombre_orden',
            5 => 'descripcion_etapa', 6 => 'nombre_estado', 7 => 'supervisor', 8 => 'responsable',
            9 => 'total_horas', 10 => 'fecha_limite', 11 => 'fecha_finalizacion'];
        $columnas = [];
        foreach ($campos as $indice => $campo) {
            $valor = $campo === 'total_horas' ? "TIME_FORMAT(total_horas, '%H:%i')" : $campo;
            $defecto = $campo === 'prioridad_servicio' ? 'S/P' : '-';
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
        $filtrados = (clone $consulta)->count();
        foreach ($request->input('order', []) as $orden) {
            $indice = (int) $orden['column'];
            if (!isset($columnas[$indice])) continue;
            $campo = $campos[$indice];
            $consulta->orderBy($campo, $orden['dir']);
        }
        if (!$request->input('order')) {
            $consulta->orderByRaw("CASE WHEN nombre_estado = 'Continua' THEN 1 ELSE 0 END")
                ->orderByRaw('CASE WHEN prioridad_servicio IS NULL THEN 1 ELSE 0 END')
                ->orderBy('prioridad_servicio');
        }
        $filas = $consulta->orderBy('id_orden')->offset((int) $request->input('start'))
            ->limit((int) $request->input('length'))->get();
        $datos = $filas->map(function ($orden) {
            $fecha = function ($valor) { return $valor ? substr((string) $valor, 0, 10) : '-'; };
            return ['id' => $orden->id_orden, 'celdas' => [
                '', e($orden->prioridad_servicio ?? 'S/P'),
                '<abbr title="'.e($orden->nombre_servicio ?? '-').'" style="text-decoration:none">'.e($orden->codigo_servicio ?? '-').' <i class="fas fa-eye"></i></abbr>',
                e($orden->codigo_servicio ?? '-'), e($orden->nombre_orden ?? '-'),
                '<abbr title="'.e($orden->descripcion_etapa).'" style="text-decoration:none">'.e(mb_substr($orden->descripcion_etapa ?? '', 0, 20)).' <i class="fas fa-eye"></i></abbr>',
                e($orden->nombre_estado ?? '-'), e($orden->supervisor ?? '-'), e($orden->responsable ?? '-'),
                e($orden->total_horas ?: '-'), $fecha($orden->fecha_limite), $fecha($orden->fecha_finalizacion),
                view('Ingenieria.Servicios.Ordenes.trabajo.acciones-tabla', ['orden' => $orden, 'tipo_orden' => 1])->render()
            ]];
        });
        $respuesta = ['draw' => (int) $request->input('draw'), 'recordsTotal' => $total,
            'recordsFiltered' => $filtrados, 'data' => $datos->values()];
        if ($request->boolean('opcionesFiltros')) {
            $respuesta['opcionesFiltros'] = [];
            foreach ($columnas as $indice => $columna) {
                $respuesta['opcionesFiltros'][$indice] = (clone $base)->selectRaw($columna.' as valor')
                    ->distinct()->orderBy('valor')->get()->pluck('valor')->map(function ($v) { return (string) $v; })->values();
            }
        }
        return response()->json($respuesta);
    }
}
