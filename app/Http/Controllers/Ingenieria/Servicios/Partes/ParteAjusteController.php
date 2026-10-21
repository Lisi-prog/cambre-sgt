<?php

namespace App\Http\Controllers\Ingenieria\Servicios\Partes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\Cambre\Parte;
use App\Models\Cambre\Parte_ajuste;
use App\Models\Cambre\Tarea_ajuste;
use App\Models\Cambre\Responsabilidad;
use App\Models\Cambre\Estado;
use App\Models\Cambre\Rol_empleado;
use App\Models\Cambre\Orden;
use App\Models\Cambre\Tarea_prev_x_activo;
use App\Models\Cambre\Actualizacion;
use App\Models\Cambre\Actualizacion_servicio;
use App\Models\Cambre\Serv_mant_x_tarea_mant;

class ParteAjusteController extends Controller{
    public function get_pre_acciones_ajuste($id_etapa)
    {
        $orden = Orden::where('id_etapa', $id_etapa)->firstOrFail();
        $servicio = $orden->getEtapa->getServicio;
        $activo = $servicio->getActivo;
        $generales = \App\Models\Cambre\Tarea_mantenimiento::where(function ($query) use ($activo) {
            $query->whereIn('id_tarea_mantenimiento', function ($asociadas) use ($activo) {
                $asociadas->select('id_tarea_mantenimiento')->from('activo_x_tarea_mant')->where('id_activo', $activo->id_activo);
            })->orWhereIn('id_tarea_mantenimiento', function ($asociadas) use ($activo) {
                $asociadas->select('id_tarea_mantenimiento')->from('tipo_activo_x_tarea_mant')->where('id_tipo_activo', $activo->id_tipo_activo);
            });
        })->with('getEjecucion', 'getZonaTarea')->orderBy('nombre_tarea')->get();
        $elementos = (new ParteInspeccionController)->get_tareas_x_activo($servicio->id_activo)->getData(true);
        $preventivas = Serv_mant_x_tarea_mant::where('id_servicio', $servicio->id_servicio)
            ->with('getTarea.getTareaMantenimiento.getEjecucion', 'getTarea.getTareaMantenimiento.getZonaTarea')->get()->map(function ($seleccion) {
                return $seleccion->getTarea->getTareaMantenimiento;
            })->unique('id_tarea_mantenimiento')->values();
        return response()->json([
            'elementos' => $elementos['tareas_x_activo'],
            'preventivas' => $preventivas,
            'generales' => $generales,
            'activo' => $servicio->getActivo,
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'id_orden' => 'required|integer|exists:orden,id_orden',
            'fecha' => 'required|date',
            'horas' => 'required|integer|min:0',
            'minutos' => 'required|integer|between:0,59',
            'tareas' => 'nullable|array',
            'tareas.*' => 'required|array',
            'tareas.*.accion' => 'required|integer|exists:accion_para_tarea,id_accion_tarea',
            'tareas.*.observaciones' => 'nullable|string|max:100',
            'tareas.*.hecho' => 'nullable|in:on,1',
            'generales' => 'nullable|array',
            'generales.*' => 'required|array',
            'generales.*.tarea_mant' => 'nullable|integer',
            'generales.*.hecho' => 'nullable|in:on,1',
            'generales.*.observaciones' => 'nullable|string|max:100',
            'generales.*.nombre_tarea' => 'nullable|string|max:255',
        ]);
        try{
            DB::beginTransaction();
            $orden = Orden::findOrFail($request->id_orden);
            $contexto = $this->get_pre_acciones_ajuste($orden->id_etapa)->getData(true);
            $generales = $request->input('generales', []);
            $todas = \App\Services\Mantenimiento\ValidarTareasParte::validar(
                $contexto, $request->input('tareas', []), $generales, $request->has('completado')
            );
            $completo =  isset($request->completado) ? 1 : 0;
            //PARTE
            $parte_revisar = new Parte;
            $parte_revisar->observaciones = "Alta de parte de tarea mantenimiento, pendiente de revisión";
            $parte_revisar->fecha = $request->fecha;
            $parte_revisar->fecha_carga = Carbon::now();
            $parte_revisar->horas = $request->horas . ':' . $request->minutos;
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
                $parte_revisar->observaciones = "Proceso de mantenimiento completo, pendiente de revisión";
                $next = 3;
            }
            else{
                $parte_revisar->observaciones = "Realizando proceso de mantenimiento";
            }
            $parte_revisar->save();

            //PARTE AJUSTE
            $parte_ajuste = new Parte_ajuste;
            $parte_ajuste->id_parte = $parte_revisar->id_parte;
            $parte_ajuste->id_estado_mantenimiento = $next;
            $parte_ajuste->save();

            //TAREAS DE AJUSTE
            if($todas){
                foreach ($todas as $tarea) {
                    $accion = $tarea['accion'] ?? null;
                    $observaciones = $tarea['observaciones'] ?? null;

                    $tarea_nueva = new Tarea_ajuste;
                    $tarea_nueva->id_parte_ajuste = $parte_ajuste->id_parte_ajuste;
                    $tarea_nueva->id_accion_tarea = $accion;

                    if (str_contains($tarea['tarea_mant'] ?? '', '-')) {
                        $clean = trim($tarea['tarea_mant'], "'");
                        $id = array_map('intval',explode('-',$clean));
                        $tarea_nueva->id_zona = $id[0];
                        $tarea_nueva->id_zona_tarea = $id[1];
                    }
                    else{
                        $tarea_nueva->id_tarea_mantenimiento = $tarea['tarea_mant'] ?? null;
                    }
                    $tarea_nueva->id_maquinaria = null;
                    $tarea_nueva->nombre_tarea = $tarea['nombre_tarea'] ?? null;
                    if (isset($tarea['observaciones'])) {
                        $tarea_nueva->observaciones = $observaciones;
                    }

                    $tarea_nueva->hecho = isset($tarea['hecho']) ? 1 : 0;

                    if($tarea_nueva->id_tarea_mantenimiento) {
                        $serv = Serv_mant_x_tarea_mant::where('id_servicio', $parte_revisar->getOrden->getEtapa->getServicio->id_servicio)
                         ->whereHas('getTarea', function ($query) use ($tarea) {
                                $query->where('id_tarea_mantenimiento', $tarea['tarea_mant']);
                            })
                        ->first();
                        if($serv && $tarea_nueva->hecho){
                            $serv->fecha_hecho = $request->fecha;
                            $serv->save();
                        }
                        $mant = Tarea_prev_x_activo::where('id_tarea_mantenimiento', $tarea['tarea_mant'])
                        ->where('id_activo', $parte_revisar->getOrden->getEtapa->getServicio->id_activo)->first();
                        if($mant && $tarea_nueva->hecho == 1){
                            $mant->fecha_ultima_ejecucion = $request->fecha;
                            $mant->save();
                        }
                    }
                    $tarea_nueva->save();
                }
            }
            DB::commit();
            return redirect()->back()->with('mensaje', 'Se ha creado con éxito el parte de tarea mantenimiento.');
        }
        catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function get_parte_ajuste($id_orden){
        $parte_ajuste = Parte_ajuste::whereHas('getParte', function($query) use ($id_orden){
        $query->where('id_orden', $id_orden);
        })
        ->with(
            'getParte.getOrden.getEtapa.getServicio.getActivo',
            'getTareasAjuste.getAccionTarea',
            'getTareasAjuste.getZona',
            'getTareasAjuste.getZonaTarea',
            'getTareasAjuste.getMaquinaria',
            'getTareasAjuste.getTareaMantenimiento.getZonaTarea',
            'getTareasAjuste.getTareaMantenimiento.getEjecucion',
        )
        ->orderByDesc('id_parte_ajuste')
        ->first();
        if($parte_ajuste) {
            $parte_ajuste->horas = $parte_ajuste->getParte->getOrden->getHoras();
        }
        return response()->json($parte_ajuste);
    }

    public function procesar_parte_ajuste(Request $request){
        try {
            DB::beginTransaction();
            $parte_ajuste = Parte_ajuste::whereHas('getParte', function($query) use ($request){
                $query->where('id_orden', $request->id_orden_mantenimiento);
            })
            ->orderByDesc('id_parte_ajuste')
            ->first();

            if($parte_ajuste){
                if($request->accion == "rechazar"){
                    $parte_nueva = new Parte;
                    $parte_nueva->observaciones = "Rechazo de orden de mantenimiento de ajuste";
                    $parte_nueva->fecha = Carbon::now();
                    $parte_nueva->fecha_carga = Carbon::now();
                    $parte_nueva->horas = 0;
                    $parte_nueva->costo = 0;
                    $parte_nueva->id_orden = $parte_ajuste->getParte->id_orden;
                    $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
                    $responsabilidad = Responsabilidad::create([
                                        'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                                        'id_rol_empleado' => $rol_empleado->id_rol_empleado
                                    ]);
                    $parte_nueva->id_responsabilidad = $responsabilidad->id_responsabilidad;
                    $parte_nueva->save();
                    $parte_ajuste_nueva = new Parte_ajuste;
                    $parte_ajuste_nueva->id_estado_mantenimiento = 5;
                    $parte_ajuste_nueva->id_parte = $parte_nueva->id_parte;
                    $parte_ajuste_nueva->save();
                }
                else if($request->accion == "aceptar"){
                    $parte_nueva = new Parte;
                    $parte_nueva->observaciones = "Aprobación de orden de mantenimiento de ajuste";
                    $parte_nueva->fecha = Carbon::now();
                    $parte_nueva->fecha_carga = Carbon::now();
                    $parte_nueva->horas = 0;
                    $parte_nueva->costo = 0;
                    $parte_nueva->id_orden = $parte_ajuste->getParte->id_orden;
                    $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
                    $responsabilidad = Responsabilidad::create([
                                        'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                                        'id_rol_empleado' => $rol_empleado->id_rol_empleado
                                    ]);
                    $parte_nueva->id_responsabilidad = $responsabilidad->id_responsabilidad;
                    $parte_nueva->save();
                    $parte_ajuste_nuevo = new Parte_ajuste();
                    $parte_ajuste_nuevo->id_estado_mantenimiento = 4;
                    $parte_ajuste_nuevo->id_parte = $parte_nueva->id_parte;
                    $parte_ajuste_nuevo->save();

                    $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
                    $responsabilidad = Responsabilidad::create([
                                        'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                                        'id_rol_empleado' => $rol_empleado->id_rol_empleado
                                    ]);

                    $estado = Estado::where('nombre_estado', 'Completo')->first();

                    $ultActServ = Actualizacion_servicio::where('id_servicio', $parte_ajuste->getParte->getOrden->getEtapa->id_servicio)->orderBy('id_actualizacion', 'desc')->first();

                    $actualizacionServicio = Actualizacion::create([
                        'descripcion' => 'Finalización del proyecto.',
                        'fecha_limite' => $ultActServ->getActualizacion->fecha_limite,
                        'fecha_carga' => Carbon::now(),
                        'id_estado' => $estado->id_estado,
                        'id_responsabilidad' => $responsabilidad->id_responsabilidad
                    ]);

                    $actualizacion_servicio = Actualizacion_servicio::create([
                        'id_actualizacion' => $actualizacionServicio->id_actualizacion,
                        'id_servicio' => $ultActServ->id_servicio
                    ]);
                }
                else{
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Acción no válida.'
                    ], 400);
                }
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Parte diagnóstico procesado exitosamente.'
                ]);
            }else{
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró un parte diagnóstico para esta orden de mantenimiento.'
                ], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function get_parte_ajuste_completado($id_orden){
        $parte_ajuste = Parte_ajuste::whereHas('getParte', function($query) use ($id_orden){
        $query->where('id_orden', $id_orden)->whereIn('id_estado_mantenimiento', [2,3]);
        })
        ->with(
            'getParte.getOrden.getEtapa.getServicio.getActivo',
            'getTareasAjuste.getAccionTarea',
            'getTareasAjuste.getZona',
            'getTareasAjuste.getZonaTarea',
            'getTareasAjuste.getMaquinaria',
            'getTareasAjuste.getTareaMantenimiento.getZonaTarea',
            'getTareasAjuste.getTareaMantenimiento.getEjecucion',
        )
        ->orderByDesc('id_parte_ajuste')
        ->first();
        if($parte_ajuste) {
            $parte_ajuste->horas = $parte_ajuste->getParte->getOrden->getHoras();
        }
        return response()->json($parte_ajuste);
    }

    public function get_parte_ajuste_porcion($id_parte){
        $parte_ajuste = Parte_ajuste::where('id_parte', $id_parte)
        ->with(
            'getParte.getOrden.getEtapa.getServicio.getActivo',
            'getTareasAjuste.getAccionTarea',
            'getTareasAjuste.getZona',
            'getTareasAjuste.getZonaTarea',
            'getTareasAjuste.getMaquinaria',
            'getTareasAjuste.getTareaMantenimiento.getZonaTarea',
            'getTareasAjuste.getTareaMantenimiento.getEjecucion',
        )
        ->orderByDesc('id_parte_ajuste')
        ->first();
        return response()->json($parte_ajuste);
    }
}
