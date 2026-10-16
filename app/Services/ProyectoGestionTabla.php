<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cambre\Servicio;

class ProyectoGestionTabla
{
    private function configuracion($grupo)
    {
        $comunes = ['nombre_orden', 'descripcion_etapa', 'nombre_estado', 'supervisor', 'responsable',
            'fecha_limite', 'fecha_finalizacion', 'horas_estimada', 'horas_real'];
        return [
            'etapas' => ['tabla' => 'vw_etapa', 'id' => 'id_etapa', 'objeto' => 'etapa',
                'campos' => ['descripcion_etapa', 'nombre_estado', 'responsable', 'fecha_inicio', 'fecha_limite',
                    'fecha_finalizacion', 'fecha_ult_act', 'horas_estimada', 'horas_real']],
            'trabajo' => ['tabla' => 'vw_gest_orden_trabajo', 'id' => 'id_orden', 'objeto' => 'orden', 'campos' => $comunes],
            'manufactura' => ['tabla' => 'vw_gest_orden_manufactura', 'id' => 'id_orden', 'objeto' => 'orden',
                'campos' => ['nombre_orden', 'conjunto_superior', 'descripcion_etapa', 'nombre_estado', 'progreso',
                    'supervisor', 'fecha_limite', 'fecha_finalizacion', 'horas_estimada', 'horas_real']],
            'mecanizado' => ['tabla' => 'vw_gest_orden_mecanizado', 'id' => 'id_orden', 'objeto' => 'orden',
                'campos' => ['nombre_orden', 'nombre_manufactura', 'descripcion_etapa', 'nombre_estado', 'supervisor',
                    'fecha_limite', 'fecha_finalizacion', 'horas_estimada', 'horas_real']],
        ][$grupo];
    }

    public function respuesta(Request $request, $id)
    {
        $request->validate([
            'grupo' => 'required|in:etapas,trabajo,manufactura,mecanizado',
            'draw' => 'required|integer|min:0', 'start' => 'required|integer|min:0',
            'length' => 'required|integer|between:1,500', 'opcion' => 'required|integer|between:1,5',
            'search.value' => 'nullable|string|max:500', 'order' => 'sometimes|array|max:10',
            'order.*.column' => 'required|integer|between:0,9', 'order.*.dir' => 'required|in:asc,desc',
            'filtrosCabecera' => 'required|json',
        ]);
        $proyecto = Servicio::findOrFail($id);
        $grupo = $request->input('grupo');
        $config = $this->configuracion($grupo);
        $base = DB::table($config['tabla'].' as v')->where('v.id_servicio', $id);
        if ($grupo === 'manufactura') {
            $base->leftJoin('orden_manufactura_asoc as asoc', 'asoc.id_orden_manufactura', '=', 'v.id_orden_manufactura')
                ->leftJoin('orden_manufactura as superior', 'superior.id_orden_manufactura', '=', 'asoc.id_orden_man_asoc')
                ->leftJoin('orden as ord_superior', 'ord_superior.id_orden', '=', 'superior.id_orden');
        }
        $columnas = [];
        foreach ($config['campos'] as $campo) {
            if ($campo === 'conjunto_superior') $expresion = "COALESCE(ord_superior.nombre_orden, '-')";
            elseif ($campo === 'progreso') $expresion = "CONCAT(COALESCE(v.tot_mec_completo, 0), ' / ', COALESCE(v.tot_mec, 0))";
            else $expresion = "COALESCE(v.".$campo.", '-')";
            // SQL views combine dates, times and text with different collations.
            $columnas[] = 'CONVERT('.$expresion.' USING utf8mb4) COLLATE utf8mb4_unicode_ci';
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
            $campo = $config['campos'][$indice];
            $expresion = $campo === 'progreso' ? 'v.tot_mec_porcentaje' : $columnas[$indice];
            if (in_array($campo, ['horas_estimada', 'horas_real'])) $expresion = 'v.'.$campo;
            $consulta->orderByRaw($expresion.' '.$orden['dir']);
        }
        $campos = ['v.*'];
        if ($grupo === 'manufactura') $campos[] = 'ord_superior.nombre_orden as conjunto_superior';
        $filas = $consulta->orderBy('v.'.$config['id'])->offset((int) $request->input('start'))
            ->limit((int) $request->input('length'))->get($campos);
        $opcion = (int) $request->input('opcion');
        $datos = $filas->map(function ($fila) use ($grupo, $config, $proyecto, $opcion) {
            $html = view('Ingenieria.Servicios.Proyectos.layout.filas-gestion.'.$grupo,
                [$config['objeto'] => $fila, 'proyecto' => $proyecto, 'opcion' => $opcion])->render();
            // The row partial contains only sibling cells, including its action menu.
            preg_match_all('/<td\b[^>]*>(.*?)<\/td>/s', $html, $celdas);
            if (count($celdas[1]) !== count($config['campos']) + 1) {
                throw new \RuntimeException('Cantidad de columnas incorrecta en la tabla de '.$grupo);
            }
            return array_map('trim', $celdas[1]);
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
