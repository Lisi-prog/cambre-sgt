<?php

namespace App\Http\Controllers\Ingenieria\Servicios\Partes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\Cambre\Parte;
use App\Models\Cambre\Parte_diagnostico;
use App\Models\Cambre\Parte_ajuste;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use App\Models\Cambre\Responsabilidad;
use App\Models\Cambre\Rol_empleado;
use App\Models\Cambre\Orden;
use App\Models\Cambre\Orden_mantenimiento;

class ParteDiagnosticoController extends Controller{
    public function sintomas(Request $request, $id)
    {
        $idOrden = $request->boolean('por_parte') ? Parte::findOrFail($id)->id_orden : $id;
        $orden = Orden::with('getEtapa.getServicio.getSolicitud')->findOrFail($idOrden);
        $solicitud = optional(optional($orden->getEtapa)->getServicio)->getSolicitud;
        $detalle = $solicitud ? ($solicitud->getServicioDeIngenieria ?? $solicitud->getServicioDeMantenimiento) : null;
        $sintomas = $detalle ? collect($detalle->getSintomasAlt())->flatMap(function ($grupo) {
            return collect($grupo['sintomas'])->pluck('nombre');
        })->filter()->unique()->values() : collect();

        return response()->json($sintomas);
    }

    private function categoriasParaOrden($id)
    {
        $orden = Orden::with('getEtapa.getServicio.getActivo.getTipoActivo')->findOrFail($id);
        $tipo = optional(optional(optional($orden->getEtapa)->getServicio)->getActivo)->getTipoActivo;
        return $tipo ? $tipo->getCategoriasDiagnostico()->orderBy('nombre_diagnostico_categoria')->get() : new Collection();
    }

    public function categorias_diagnostico($id)
    {
        return $this->categoriasParaOrden($id)->load(['getDiagnosticos' => function ($query) {
            $query->where('en_uso', 1)->orderBy('nombre_diagnostico');
        }]);
    }

    public function store(Request $request){
        $categorias = $this->categoriasParaOrden($request->id_orden);
        $datos = $request->validate([
            'diagnosticos' => 'required|array|min:1',
            'diagnosticos.*' => ['required', 'integer', 'distinct', Rule::exists('diagnostico', 'id_diagnostico')->where(function ($query) use ($categorias) {
                $query->whereIn('id_diagnostico_categoria', $categorias->modelKeys())->where('en_uso', 1);
            })],
        ]);
        try {    
            DB::beginTransaction();
            //PARTE
                $parte = new Parte;
                $parte->observaciones = $request->observacion;
                $parte->id_orden = $request->id_orden;
                $parte->fecha = $request->fecha;
                $parte->horas = $request->horas . ':' . $request->minutos;
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
                $next = 2;
                if($request->completado){
                    if( $parte_diagnostico->en_maquina == 1){
                        $parte_diagnostico->id_estado = 3;
                        $parte_diagnostico->completado = 1;
                    }
                    else{
                        $parte_diagnostico->id_estado = 4;
                        $parte_diagnostico->completado = 1;
                    }                    
                }
                else{
                    $next = 1;
                    $parte_diagnostico->id_estado = 2;
                    $parte_diagnostico->completado = 0;    
                }
                $parte_diagnostico->id_parte = $parte->id_parte;
                $parte_diagnostico->save();
                $parte_diagnostico->getDiagnosticos()->sync($datos['diagnosticos']);
                if($next == 2 &&  $parte_diagnostico->en_maquina == 0){
                    $orden_vieja = Orden::find($request->id_orden);    
                    $orden_nueva = new Orden;                
                    $orden_nueva->nombre_orden = $request->nombre_proyecto . '-TAREA MANTENIMIENTO';
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
                    $parte->observaciones = "Generacion de orden de tarea de mantenimiento";
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
                    $parte_mantenimiento = new Parte_ajuste;
                    $parte_mantenimiento->id_parte = $parte->id_parte;
                    $parte_mantenimiento->id_estado_mantenimiento = 1;
                    $parte_mantenimiento->save();
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
            'getDiagnosticos.getCategoria'
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

    public function get_parte_diagnostico_completado($id_orden_mantenimiento){
        $parte_diagnostico = Parte_diagnostico::whereHas('getParte', function($query) use ($id_orden_mantenimiento){
        $query->where('id_orden', $id_orden_mantenimiento)->whereIn('id_estado', [2, 3, 4]);
        })
        ->with('getParte.getResponsable.getEmpleado',
            'getParte.getOrden',
            'getDiagnosticos.getCategoria')
        ->get();
        if ($parte_diagnostico->isNotEmpty()) {
            $parte_diagnostico[0]->horas = $parte_diagnostico[0]->getParte->getOrden->getHoras();
        }
        return $parte_diagnostico;
    }

     public function get_parte_diagnostico_porcion($id_parte){
        $parte_diagnostico = Parte_diagnostico::where('id_parte', $id_parte)
        ->with(
            'getParte',
            'getDiagnosticos.getCategoria'
        )
        ->orderByDesc('id_parte_diagnostico')
        ->first();
        return response()->json($parte_diagnostico);
    }

    public function aceptar_mantenimiento_diagnostico(Request $request){
        try {
            DB::beginTransaction();
            $parte_diagnostico = Parte_diagnostico::whereHas('getParte', function($query) use ($request){
            $query->where('id_orden', $request->id_orden)->whereIn('id_estado', [3]);
            })
            ->first();
            $parte_diagnostico->id_estado = 4;
            $parte_diagnostico->completado = 1;
            $parte_diagnostico->save();
            DB::commit();
            return response()->json([
                'success' => true, 
                'message' => 'Mantenimiento aceptado exitosamente.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
