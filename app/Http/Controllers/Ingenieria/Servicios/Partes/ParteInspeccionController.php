<?php

namespace App\Http\Controllers\Ingenieria\Servicios\Partes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\Cambre\Parte;
use App\Models\Cambre\Activo;
use App\Models\Cambre\Orden;
use App\Models\Cambre\Orden_mantenimiento;
use App\Models\Cambre\Parte_inspeccion;
use App\Models\Cambre\Parte_ajuste;
use App\Models\Cambre\Responsabilidad;
use App\Models\Cambre\Rol_empleado;
use App\Models\Cambre\Tarea_mantenimiento;
use App\Models\Cambre\Parte_inspe_x_tarea_mant;

class ParteInspeccionController extends Controller{
    public function store(Request $request){
        try{
            DB::beginTransaction();
            $completo =  isset($request->completo) ? 1 : 0;
            //PARTE
            $parte_revisar = new Parte;
            $parte_revisar->fecha = $request->fecha;
            $parte_revisar->fecha_carga = Carbon::now();
            $parte_revisar->horas = $request->horas;
            $parte_revisar->costo = 0;
            $parte_revisar->id_orden = $request->id_orden;
            $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
            $responsabilidad = Responsabilidad::create([
                                    'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                                    'id_rol_empleado' => $rol_empleado->id_rol_empleado
                                ]);
            $parte_revisar->id_responsabilidad = $responsabilidad->id_responsabilidad;
            $next = 2;
            if($completo){
                $parte_revisar->observaciones = "Proceso de inspección completo.";
                $next = 4;
            }
            else{
                $parte_revisar->observaciones = "Realizando proceso de inspección";                
            }
            $parte_revisar->save();
            //PARTE INSPECCIÓN
            $parte_inspeccion = new Parte_inspeccion;
            $parte_inspeccion->id_parte = $parte_revisar->id_parte;
            $parte_inspeccion->id_estado_mantenimiento = $next;
            $parte_inspeccion->save();           
            //TAREAS    
            foreach ($request['tareas'] as $tarea) {
                if (isset($tarea['ok'])) {
                    $id = $tarea['id'];
                    $ok = $tarea['ok'];
                    $accion = $tarea['accion'] ?? null;
                    $tarea_existe = Parte_inspe_x_tarea_mant::where('id_tarea_mantenimiento', $id)
                        ->whereHas('getParte.getParte.getOrden', function ($query) use ($parte_inspeccion) {
                            $query->where('id_orden', $parte_inspeccion->getParte->getOrden->id_orden);
                        })
                        ->first();
                    if ($tarea_existe) {
                        if ($ok === 'ok') {
                            $tarea_existe->ok = 1;
                            $tarea_existe->id_accion = null;
                        } else {
                            $tarea_existe->ok = 0;
                            $tarea_existe->id_accion = $accion;
                        }
                        $tarea_existe->save();
                    } else {
                        $tarea_nueva = new Parte_inspe_x_tarea_mant;
                        $tarea_nueva->id_parte_inspeccion = $parte_inspeccion->id_parte_inspeccion;
                        $tarea_nueva->id_tarea_mantenimiento = $id;
                        if ($ok === 'ok') {
                            $tarea_nueva->ok = 1;
                            $tarea_nueva->id_accion = null;
                        } else {
                            $tarea_nueva->ok = 0;
                            $tarea_nueva->id_accion = $accion;
                        }
                        $tarea_nueva->save();
                    }
                }
            }
            if($next == 4){
                $orden_vieja = Orden::find($request->id_orden);
                $orden_nueva = new Orden;                
                $orden_nueva->nombre_orden = $request->nombre_proyecto . '-AJUSTE';
                $orden_nueva->fecha_inicio = Carbon::now();
                $orden_nueva->duracion_estimada = 0;
                $orden_nueva->id_etapa = $orden_vieja->id_etapa;
                $orden_nueva->costo_estimado = 0;   
                $orden_nueva->save();
                $orden_mantenimiento = new Orden_mantenimiento;
                $orden_mantenimiento->id_tipo_orden_mantenimiento = 3;
                $orden_mantenimiento->esta_activo = 1;
                $orden_mantenimiento->id_orden = $orden_nueva->id_orden;
                $orden_mantenimiento->save();
                $parte = new Parte;
                $parte->observaciones = "Generacion de orden de mantenimiento de ajuste";
                $parte->fecha = Carbon::now();
                $parte->fecha_carga = Carbon::now();
                $parte->horas = 0;
                $parte->costo = 0;
                $parte->id_orden = $orden_nueva->id_orden;
                $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
                $responsabilidad = Responsabilidad::create([
                                    'id_empleado' => 999,
                                    'id_rol_empleado' => $rol_empleado->id_rol_empleado
                                ]);
                $parte->id_responsabilidad = $responsabilidad->id_responsabilidad;
                $parte->save();
                $parte_ajuste_nueva = new Parte_ajuste;
                $parte_ajuste_nueva->id_parte = $parte->id_parte;
                $parte_ajuste_nueva->id_estado_mantenimiento = 1;
                $parte_ajuste_nueva->save();
            }
            DB::commit();
            return redirect()->back()->with('mensaje', 'Se ha creado con éxito el parte de inspección.');
        }
        catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());        
        }
    }

    public function get_tareas_x_activo($id_activo){
        $activo = Activo::find($id_activo);
        $tareasMantenimiento = Tarea_mantenimiento::leftJoin(
            'activo_x_tarea_mant',
            'tarea_mantenimiento.id_tarea_mantenimiento',
            '=',
            'activo_x_tarea_mant.id_tarea_mantenimiento'
        )
        ->leftJoin(
            'tipo_activo_x_tarea_mant',
            'tarea_mantenimiento.id_tarea_mantenimiento',
            '=',
            'tipo_activo_x_tarea_mant.id_tarea_mantenimiento'
        )
        ->where(function($q) use ($id_activo, $activo) {
            $q->where('activo_x_tarea_mant.id_activo', $id_activo)
            ->orWhere('tipo_activo_x_tarea_mant.id_tipo_activo', $activo->id_tipo_activo);
        })
        ->with(['getZonaTarea', 'getEjecucion'])
        ->select(
            'tarea_mantenimiento.id_tarea_mantenimiento',
            'tarea_mantenimiento.nombre_tarea',
            'tarea_mantenimiento.id_zona_tarea',
            'tarea_mantenimiento.id_ejecucion'
        )
        ->orderBy('tarea_mantenimiento.id_zona_tarea','desc')
        ->orderBy('tarea_mantenimiento.nombre_tarea','asc')
        ->get();
        return response()->json([
            'tareas_x_activo' => $tareasMantenimiento,
        ]);
    }

    public function get_parte_inspeccion($id_orden){
        $parte_inspeccion = Parte_inspeccion::whereHas('getParte', function($query) use ($id_orden){
        $query->where('id_orden', $id_orden);
        })
        ->with(
            'getParte.getResponsable.getEmpleado',
            'getParte.getOrden'
        )
        ->orderByDesc('id_parte_inspeccion')
        ->first();
        if ($parte_inspeccion) {
            $orden = $parte_inspeccion->getParte->getOrden;

            $orden->parte_inspe_x_tareas_mantenimiento =
                $orden->getParteInspeXTareasMantenimiento()
                ->with('getTareaMantenimiento.getZonaTarea',
            'getTareaMantenimiento.getEjecucion',
            'getAccionParaTarea')
            ->get();
        }
        $parte_inspeccion->horas = $parte_inspeccion->getParte->getOrden->getHoras();
        return response()->json($parte_inspeccion);
    }   

    public function get_parte_inspeccion_pendiente($id_activo, $id_orden){
        $activo = Activo::find($id_activo);

        $parte_inspeccion = Parte_inspeccion::whereHas('getParte', function($query) use ($id_orden){
        $query->where('id_orden', $id_orden);
        })
        ->with(
            'getParte.getResponsable.getEmpleado',
            'getParte.getOrden',
            'getTareasMantenimiento.getTareaMantenimiento.getZonaTarea',
            'getTareasMantenimiento.getTareaMantenimiento.getEjecucion',
            'getTareasMantenimiento.getAccionParaTarea',
        )
        ->orderByDesc('id_parte_inspeccion')
        ->first();

        $tareasMantenimiento = Tarea_mantenimiento::leftJoin(
                'activo_x_tarea_mant',
                'tarea_mantenimiento.id_tarea_mantenimiento',
                '=',
                'activo_x_tarea_mant.id_tarea_mantenimiento'
            )
            ->leftJoin(
                'tipo_activo_x_tarea_mant',
                'tarea_mantenimiento.id_tarea_mantenimiento',
                '=',
                'tipo_activo_x_tarea_mant.id_tarea_mantenimiento'
            )
            ->leftJoin('parte_inspe_x_tarea_mant', function ($join) use ($id_orden) {
                $join->on(
                    'tarea_mantenimiento.id_tarea_mantenimiento',
                    '=',
                    'parte_inspe_x_tarea_mant.id_tarea_mantenimiento'
                )
                ->join(
                    'parte_inspeccion',
                    'parte_inspe_x_tarea_mant.id_parte_inspeccion',
                    '=',
                    'parte_inspeccion.id_parte_inspeccion'
                )
                ->join(
                    'parte',
                    'parte_inspeccion.id_parte',
                    '=',
                    'parte.id_parte'
                )
                ->leftJoin('accion_para_tarea', 'accion_para_tarea.id_accion_tarea', 'parte_inspe_x_tarea_mant.id_accion')
                ->where('parte.id_orden', $id_orden);
            })

            ->where(function($q) use ($id_activo, $activo) {
                $q->where('activo_x_tarea_mant.id_activo', $id_activo)
                ->orWhere('tipo_activo_x_tarea_mant.id_tipo_activo', $activo->id_tipo_activo);
            })
            ->with(['getZonaTarea', 'getEjecucion'])
            ->select(
                'tarea_mantenimiento.id_tarea_mantenimiento',
                'tarea_mantenimiento.nombre_tarea',
                'tarea_mantenimiento.id_zona_tarea',
                'tarea_mantenimiento.id_ejecucion', 
                'parte_inspe_x_tarea_mant.ok',
                'accion_para_tarea.*'
            )
            ->orderBy('tarea_mantenimiento.id_zona_tarea','desc')
            ->orderBy('tarea_mantenimiento.nombre_tarea','asc')
            ->get();

        return ["parte" => $parte_inspeccion, "tareasMantenimiento" => $tareasMantenimiento];
    }

    public function get_parte_inspeccion_completado($id_orden){
        $parte_inspeccion = Parte_inspeccion::whereHas('getParte', function($query) use ($id_orden){
        $query->where('id_orden', $id_orden)->whereIn('id_estado_mantenimiento', [2,4]);
        })
        ->with(
            'getParte.getResponsable.getEmpleado',
            'getParte.getOrden'
        )
        ->orderByDesc('id_parte_inspeccion')
        ->first();
        if ($parte_inspeccion) {
            $orden = $parte_inspeccion->getParte->getOrden;

            $orden->parte_inspe_x_tareas_mantenimiento =
                $orden->getParteInspeXTareasMantenimiento()
                ->with('getTareaMantenimiento.getZonaTarea',
            'getTareaMantenimiento.getEjecucion',
            'getAccionParaTarea')
            ->get();
        }
        $parte_inspeccion->horas = $parte_inspeccion->getParte->getOrden->getHoras();
        return response()->json($parte_inspeccion);
    }

    public function get_parte_inspeccion_porcion($id_parte){
        $parte_inspeccion = Parte_inspeccion::where('id_parte', $id_parte)
        ->with(
            'getParteInspeXTareasMantenimiento.getTareaMantenimiento.getZonaTarea',
            'getParteInspeXTareasMantenimiento.getTareaMantenimiento.getEjecucion',
            'getParteInspeXTareasMantenimiento.getAccionParaTarea',
            'getParte.getOrden'
        )
        ->orderByDesc('id_parte_inspeccion')
        ->first();
        return response()->json($parte_inspeccion);
    }
}