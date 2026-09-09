<?php

namespace App\Http\Controllers\Ingenieria\Servicios\Partes;
use App\Http\Controllers\Controller;
use App\Models\Cambre\Zona_tarea;
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
use App\Models\Cambre\Parte_inspe_x_elemento;
use App\Models\Cambre\Serv_mant_x_tarea_mant;
use App\Models\Cambre\Tarea_ajuste;

class ParteInspeccionController extends Controller{
    public function store(Request $request){
        try{
            DB::beginTransaction();
            $completo =  isset($request->completo) ? 1 : 0;
            //PARTE
            $parte_revisar = new Parte;
            $parte_revisar->fecha = $request->fecha;
            $parte_revisar->fecha_carga = Carbon::now();
            $parte_revisar->horas =  $request->horas . ':' . $request->minutos;
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
            if(isset($request['tareas'])) {
                foreach ($request['tareas'] as $tarea) {
                    if (isset($tarea['ok'])) {
                        $clean = trim($tarea['id'], "'");
                        $id = array_map('intval',explode('-',$clean));
                        $ok = $tarea['ok'];
                        $accion = $tarea['accion'] ?? null;
                        $tarea_existe = Parte_inspe_x_elemento::where('id_zona', $id[0])
                            ->where('id_zona_tarea', $id[1])
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
                            $tarea_nueva = new Parte_inspe_x_elemento;
                            $tarea_nueva->id_parte_inspeccion = $parte_inspeccion->id_parte_inspeccion;
                            $tarea_nueva->id_zona = $id[0];
                            $tarea_nueva->id_zona_tarea = $id[1];
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
                $servicio = $parte->getOrden->getEtapa->getServicio;
                $tareas_no_ok = Parte_inspe_x_elemento::whereHas('getParte.getParte.getOrden', function ($query) use ($request) {
                    $query->where('id_orden', $request->id_orden);
                })->where('ok', 0)->get();

                foreach($tareas_no_ok as $tarea_inspeccion){
                    $tarea_ajuste = new Tarea_ajuste;
                    $tarea_ajuste->id_parte_ajuste = $parte_ajuste_nueva->id_parte_ajuste;
                    $tarea_ajuste->id_accion_tarea = $tarea_inspeccion->id_accion ?? 5;
                    $tarea_ajuste->id_zona = $tarea_inspeccion->id_zona;
                    $tarea_ajuste->id_zona_tarea = $tarea_inspeccion->id_zona_tarea; 
                    $tarea_ajuste->id_maquinaria = $servicio->getActivo->id_maquinaria;
                    $tarea_ajuste->hecho = 0;
                    $tarea_ajuste->save();
                }
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
        $tareasMantenimiento = Zona_tarea::leftJoin(
            'zona_x_zona_tarea',
            'Zona_tarea.id_zona_tarea',
            '=',
            'zona_x_zona_tarea.id_zona_tarea'
        )
        ->join('Zona_x_tipo_activo', function ($join) use ($id_activo) {
            $join->on(
                'zona_x_zona_tarea.id_zona',
                '=',
                'Zona_x_tipo_activo.id_zona'
            )
            ->where('Zona_x_tipo_activo.id_tipo_activo', function ($query) use ($id_activo) {
                $query->select('id_tipo_activo')
                    ->from('activo')
                    ->where('id_activo', $id_activo)
                    ->limit(1);
            });
        })
        ->leftJoin(
            'zona',
            'zona.id_zona',
            '=',
            'zona_x_zona_tarea.id_zona'
        )
        ->select(
            'Zona_tarea.id_zona_tarea',
            'zona_tarea.nombre_zona',
            'zona.nombre_zona as elemento',
            'zona.id_zona'
        )
        ->orderBy('nombre_zona','asc')
        ->orderBy('elemento','asc')
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
           $parte_inspeccion->elementos = Parte_inspe_x_elemento::where('id_parte_inspeccion', $parte_inspeccion->id_parte_inspeccion)
            ->with('getZona', 'getZonaTarea', 'getAccionParaTarea')
            ->get()
            ->sortBy(function ($elemento) {
                return optional($elemento->getZonaTarea)->nombre_zona;
            })
            ->values();
            $parte_inspeccion->horas = $parte_inspeccion->getParte->getOrden->getHoras();
        }
        return response()->json($parte_inspeccion);
    }   

    public function get_parte_inspeccion_pendiente($id_activo, $id_orden){
        $activo = Activo::find($id_activo);

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
            $parte_inspeccion->elementos = Parte_inspe_x_elemento::where('id_parte_inspeccion', $parte_inspeccion->id_parte_inspeccion)
                ->with('getZona', 'getZonaTarea', 'getAccionParaTarea')
                ->get();
        }

        $tareasMantenimiento = Zona_tarea::leftJoin(
            'zona_x_zona_tarea',
            'Zona_tarea.id_zona_tarea',
            '=',
            'zona_x_zona_tarea.id_zona_tarea'
        )
        ->join('Zona_x_tipo_activo', function ($join) use ($activo) {
            $join->on(
                'zona_x_zona_tarea.id_zona',
                '=',
                'Zona_x_tipo_activo.id_zona'
            )
            ->where('Zona_x_tipo_activo.id_tipo_activo', $activo->id_tipo_activo);
        })
        ->leftJoin(
            'zona',
            'zona.id_zona',
            '=',
            'zona_x_zona_tarea.id_zona'
        )
        ->leftJoin('parte_inspe_x_elemento', function ($join) use ($id_orden) {
            $join->on('zona_x_zona_tarea.id_zona', '=', 'parte_inspe_x_elemento.id_zona')
                 ->on('zona_x_zona_tarea.id_zona_tarea', '=', 'parte_inspe_x_elemento.id_zona_tarea')
                 ->join('parte_inspeccion', 'parte_inspe_x_elemento.id_parte_inspeccion', '=', 'parte_inspeccion.id_parte_inspeccion')
                 ->join('parte', 'parte_inspeccion.id_parte', '=', 'parte.id_parte')
                 ->where('parte.id_orden', $id_orden);
        })
        ->leftJoin('accion_para_tarea', 'accion_para_tarea.id_accion_tarea', '=', 'parte_inspe_x_elemento.id_accion')
        ->select(
            'Zona_tarea.id_zona_tarea',
            'zona_tarea.nombre_zona',
            'zona.nombre_zona as elemento',
            'zona.id_zona',
            'parte_inspe_x_elemento.ok',
            'accion_para_tarea.*'
        )
        ->orderBy('zona_tarea.nombre_zona', 'desc')
        ->orderBy('elemento', 'asc')
        ->get();

        return ["parte" => $parte_inspeccion, "tareasMantenimiento" => $tareasMantenimiento];
    }

   public function get_parte_inspeccion_completado($id_orden){
        $partes_inspeccion = Parte_inspeccion::whereHas('getParte', function($query) use ($id_orden){
            $query->where('id_orden', $id_orden)->whereIn('id_estado_mantenimiento', [2,3,4]);
        })
        ->with([
            'getParte.getResponsable.getEmpleado',
            'getParte.getOrden'
        ])
        ->orderByDesc('id_parte_inspeccion')
        ->get();

        foreach ($partes_inspeccion as $parte_inspeccion) {
           $parte_inspeccion->elementos = Parte_inspe_x_elemento::where('parte_inspe_x_elemento.id_parte_inspeccion', $parte_inspeccion->id_parte_inspeccion)
            ->with(['getZona', 'getZonaTarea', 'getAccionParaTarea'])
            ->join('zona_tarea', 'parte_inspe_x_elemento.id_zona_tarea', '=', 'zona_tarea.id_zona_tarea') // Ajusta el nombre de la tabla y clave si es necesario
            ->orderBy('zona_tarea.nombre_zona', 'asc')
            ->select('parte_inspe_x_elemento.*')
            ->get();
            $parte_inspeccion->horas = $parte_inspeccion->getParte->getOrden->getHoras();
        }

        return response()->json($partes_inspeccion);
    }
    public function get_parte_inspeccion_porcion($id_parte){
        $parte_inspeccion = Parte_inspeccion::where('id_parte', $id_parte)
        ->with(
            'getParte.getOrden'
        )
        ->orderByDesc('id_parte_inspeccion')
        ->first();

      if ($parte_inspeccion) {
            $parte_inspeccion->elementos = Parte_inspe_x_elemento::where('parte_inspe_x_elemento.id_parte_inspeccion', $parte_inspeccion->id_parte_inspeccion)
                ->with(['getZona', 'getZonaTarea', 'getAccionParaTarea'])
                ->join('zona_tarea', 'parte_inspe_x_elemento.id_zona_tarea', '=', 'zona_tarea.id_zona_tarea')
                ->orderBy('zona_tarea.nombre_zona', 'asc')
                ->select('parte_inspe_x_elemento.*')
                ->get();
        }
        return response()->json($parte_inspeccion);
    }
}