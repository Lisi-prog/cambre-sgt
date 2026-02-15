<?php

namespace App\Http\Controllers\Ingenieria\Servicios\Partes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\Cambre\Parte;
use App\Models\Cambre\Parte_diagnostico;
use App\Models\Cambre\Parte_inspeccion;
use App\Models\Cambre\Parte_diag_x_causa;
use App\Models\Cambre\Responsabilidad;
use App\Models\Cambre\Rol_empleado;
use App\Models\Cambre\Orden;
use App\Models\Cambre\Orden_mantenimiento;

class ParteDiagnosticoController extends Controller{
    public function store(Request $request){
        try {    
            DB::beginTransaction();
            //PARTE
                $parte = new Parte;
                $parte->observaciones = "Alta de parte diagnóstico, pendiente de revisión";
                $parte->id_orden = $request->id_orden;
                $parte->fecha = $request->fecha;
                $parte->horas = $request->horas;
                $parte->fecha_carga = Carbon::now();
                $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
                $responsabilidad = Responsabilidad::create([
                                        'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                                        'id_rol_empleado' => $rol_empleado->id_rol_empleado
                                    ]);
                $parte->id_responsabilidad = $responsabilidad->id_responsabilidad;
                $parte->save();
            //PARTE DIAGNOSTICO
                $parte_diagnostico =  new Parte_diagnostico;
                if($request->a_resolver == "Máquina"){
                    $parte_diagnostico->en_maquina = 1;
                    $parte_diagnostico->en_banco = 0;
                }
                else{
                    $parte_diagnostico->en_maquina = 0;
                    $parte_diagnostico->en_banco = 1;    
                }
                $parte_diagnostico->id_estado = 2;
                $parte_diagnostico->id_parte = $parte->id_parte;
                $parte_diagnostico->save();
            //Parte_diag_x_causa
                for($i=0; $i<count($request->ishikawa_categoria); $i++){
                    $parte_diag_x_causa = new Parte_diag_x_causa;
                    $parte_diag_x_causa->id_parte_diagnostico = $parte_diagnostico->id_parte_diagnostico;
                    $parte_diag_x_causa->id_ishikawa_causa = $request->ishikawa_causa[$i];
                    $parte_diag_x_causa->save();
                }
            DB::commit();
            return redirect()->back()->with("mensaje","Parte diagnóstico creado exitosamente.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function get_parte_diagnostico($id_orden_mantenimiento){
        $parte_diagnostico = Parte_diagnostico::whereHas('getParte', function($query) use ($id_orden_mantenimiento){
        $query->where('id_orden', $id_orden_mantenimiento);
        })
        ->with(
            'getParte.getResponsable.getEmpleado',
            'getParte.getOrden',
            'getParteDiagXCausa.getIshikawaCausa.getCategoria'
        )
        ->orderByDesc('id_parte_diagnostico')
        ->first();

        if($parte_diagnostico){
            return response()->json([
                'success' => true,
                'data' => $parte_diagnostico
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No se encontró un parte diagnóstico para esta orden de mantenimiento.'
            ], 404);
        }
    }

    public function procesar_parte_diagnostico(Request $request){
        try {        
            DB::beginTransaction();    
            $parte_diagnostico = Parte_diagnostico::whereHas('getParte', function($query) use ($request){
                $query->where('id_orden', $request->id_orden_mantenimiento);
            })
            ->orderByDesc('id_parte_diagnostico')
            ->first();

            if($parte_diagnostico){
                if($request->accion == "rechazar"){
                    $parte_nueva = new Parte;
                    $parte_nueva->observaciones = "Rechazo de orden de mantenimiento de diagnóstico";
                    $parte_nueva->fecha = Carbon::now();
                    $parte_nueva->fecha_carga = Carbon::now();
                    $parte_nueva->horas = 0;
                    $parte_nueva->costo = 0;
                    $parte_nueva->id_orden = $parte_diagnostico->getParte->id_orden;
                    $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
                    $responsabilidad = Responsabilidad::create([
                                        'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                                        'id_rol_empleado' => $rol_empleado->id_rol_empleado
                                    ]);
                    $parte_nueva->id_responsabilidad = $responsabilidad->id_responsabilidad;
                    $parte_nueva->save();
                    $parte_diagnostico_nuevo = new Parte_diagnostico;
                    $parte_diagnostico_nuevo->id_estado = 4;
                    $parte_diagnostico_nuevo->id_parte = $parte_nueva->id_parte;
                    $parte_diagnostico_nuevo->save();
                }
                else if($request->accion == "aceptar"){
                    $parte_diagnostico->id_estado = 3;
                    $orden_vieja = Orden::find($request->id_orden_mantenimiento);
                    $orden_nueva = new Orden;                
                    $orden_nueva->nombre_orden = $request->nombre_proyecto . '-inspeccion';
                    $orden_nueva->fecha_inicio = Carbon::now();
                    $orden_nueva->duracion_estimada = 0;
                    $orden_nueva->id_etapa = $orden_vieja->id_etapa;
                    $orden_nueva->costo_estimado = 0;   
                    $orden_nueva->save();
                    $orden_mantenimiento = new Orden_mantenimiento;
                    $orden_mantenimiento->id_tipo_orden_mantenimiento = 2;
                    $orden_mantenimiento->id_orden = $orden_nueva->id_orden;
                    $orden_mantenimiento->save();
                    $parte = new Parte;
                    $parte->observaciones = "Generacion de orden de mantenimiento de inspección";
                    $parte->fecha = Carbon::now();
                    $parte->fecha_carga = Carbon::now();
                    $parte->horas = 0;
                    $parte->costo = 0;
                    $parte->id_orden = $orden_nueva->id_orden;
                    $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
                    $responsabilidad = Responsabilidad::create([
                                        'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                                        'id_rol_empleado' => $rol_empleado->id_rol_empleado
                                    ]);
                    $parte->id_responsabilidad = $responsabilidad->id_responsabilidad;
                    $parte->save();
                    $parte_inspeccion = new Parte_inspeccion;
                    $parte_inspeccion->id_parte = $parte->id_parte;
                    $parte_inspeccion->id_estado_mantenimiento = 1;
                    $parte_inspeccion->save();
                    $parte_nueva = new Parte;
                    $parte_nueva->observaciones = "Aprobación de orden de mantenimiento de diagnóstico";
                    $parte_nueva->fecha = Carbon::now();
                    $parte_nueva->fecha_carga = Carbon::now();
                    $parte_nueva->horas = 0;
                    $parte_nueva->costo = 0;
                    $parte_nueva->id_orden = $parte_diagnostico->getParte->id_orden;
                    $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
                    $responsabilidad = Responsabilidad::create([
                                        'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                                        'id_rol_empleado' => $rol_empleado->id_rol_empleado
                                    ]);
                    $parte_nueva->id_responsabilidad = $responsabilidad->id_responsabilidad;
                    $parte_nueva->save();
                    $parte_diagnostico_nuevo = new Parte_diagnostico;
                    $parte_diagnostico_nuevo->id_estado = 3;
                    $parte_diagnostico_nuevo->id_parte = $parte_nueva->id_parte;
                    $parte_diagnostico_nuevo->save();
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

}