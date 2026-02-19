<?php

namespace App\Http\Controllers\Ingenieria\Servicios\Partes;
use App\Http\Controllers\Controller;
use App\Models\Cambre\Parte_inspeccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\Cambre\Parte;
use App\Models\Cambre\Parte_ajuste;
use App\Models\Cambre\Tarea_ajuste;
use App\Models\Cambre\Responsabilidad;
use App\Models\Cambre\Rol_empleado;
use App\Models\Cambre\Orden;
use App\Models\Cambre\Orden_mantenimiento;

class ParteAjusteController extends Controller{
    public function get_pre_acciones_ajuste($id_etapa)
    {
        $parte_inspeccion = Parte_inspeccion::whereHas('getParte.getOrden', function ($query) use ($id_etapa) {
                $query->where('id_etapa', $id_etapa)
                    ->whereIn('id_estado_mantenimiento', [2,3]);
            })
            ->whereHas('getTareasMantenimiento.getTareaMantenimiento', function ($query) {
                $query->where('ok', 0);
            })
            ->with([
                'getParte.getResponsable.getEmpleado',
                'getParte.getOrden.getEtapa',
                'getTareasMantenimiento' => function ($query) {
                    $query->where('ok', 0);
                },

                'getTareasMantenimiento.getTareaMantenimiento.getZonaTarea',
                'getTareasMantenimiento.getTareaMantenimiento.getEjecucion',
                'getTareasMantenimiento.getAccionParaTarea'
            ])
            ->orderByDesc('id_parte_inspeccion')
            ->get();

        return $parte_inspeccion;
    }

    public function store(Request $request){
        //return $request;    
        try{
            DB::beginTransaction();
            $completo =  isset($request->completado) ? 1 : 0;
            //PARTE
            $parte_revisar = new Parte;
            $parte_revisar->observaciones = "Alta de parte de ajuste, pendiente de revisión";;
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
                $parte_revisar->observaciones = "Proceso de ajuste completo, pendiente de revisión";
                $next = 3;
            }
            else{
                $parte_revisar->observaciones = "Realizando proceso de ajuste";                
            }
            $parte_revisar->save();
            //PARTE AJUSTE
            $parte_ajuste = new Parte_ajuste;
            $parte_ajuste->id_parte = $parte_revisar->id_parte;
            $parte_ajuste->id_estado_mantenimiento = $next;
            $parte_ajuste->save();
            //TAREAS DE AJUSTE   
            foreach ($request['tareas'] as $tarea) {
                $accion = $tarea['accion'];
                $zona = $tarea['zona'];
                $maquina = $tarea['maquina'];
                $tarea_nueva = new Tarea_ajuste;
                $tarea_nueva->id_parte_ajuste = $parte_ajuste->id_parte_ajuste;
                $tarea_nueva->id_accion_tarea = $accion;
                $tarea_nueva->id_zona = $zona;
                $tarea_nueva->id_tarea_mantenimiento = $tarea['tarea_mant'];
                $tarea_nueva->id_maquinaria = $maquina;
                $tarea_nueva->hecho = isset($tarea['hecho']) ? 1 : 0;
                $tarea_nueva->save();
            }
            DB::commit();
            return redirect()->back()->with('mensaje', 'Se ha creado con éxito el parte de ajuste.');
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
            'getParte.getOrden', 
            'getTareasAjuste.getAccionTarea', 
            'getTareasAjuste.getZona',
            'getTareasAjuste.getMaquinaria',
            'getTareasAjuste.getTareaMantenimiento',
        )
        ->orderByDesc('id_parte_ajuste')
        ->first();
        $parte_ajuste->horas = $parte_ajuste->getParte->getOrden->getHoras();
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
            'getParte.getOrden', 
            'getTareasAjuste.getAccionTarea', 
            'getTareasAjuste.getZona',
            'getTareasAjuste.getMaquinaria',
            'getTareasAjuste.getTareaMantenimiento',
        )
        ->orderByDesc('id_parte_ajuste')
        ->first();
        $parte_ajuste->horas = $parte_ajuste->getParte->getOrden->getHoras();
        return response()->json($parte_ajuste);
    }

}