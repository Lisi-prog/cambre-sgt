<?php

namespace App\Http\Controllers\Ingenieria\Servicios\Ordenes;
use App\Http\Controllers\Controller;

use App\Models\Cambre\Tarea_mantenimiento;
use Illuminate\Http\Request;

//agregamos
use \PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Cambre\Estado_hdr;
use App\Models\Cambre\Operacion;
use App\Models\Cambre\Empleado;
use App\Models\Cambre\Maquinaria;
use App\Models\Cambre\Vw_operaciones_de_hdr;
use App\Models\Cambre\Orden_mantenimiento;
use App\Models\Cambre\Tipo_orden_mantenimiento;
use App\Models\Cambre\Ishikawa_categoria;
use App\Models\Cambre\Ishikawa_causa;
use App\Models\Cambre\Accion_para_tarea;
use App\Models\Cambre\Zona;

class OrdenMantenimientoController extends Controller
{

public function index(){
        $flt_operaciones = Operacion::orderBy('nombre_operacion')->pluck('nombre_operacion');
        $orden_mantimiento = Tipo_orden_mantenimiento::where('id_tipo_orden_mantenimiento', '<>', 3)->orderBy('id_tipo_orden_mantenimiento')->pluck('nombre_tipo_orden_mantenimiento');
        $flt_operaciones = $flt_operaciones->merge($orden_mantimiento)->sort();
        $flt_operaciones_tec = [];

        if (Auth::user()->hasRole('SUPERVISOR') || Auth::user()->hasRole('ADMIN')) {
        } else {
            $opeDeUsuario = Auth::user()->getOperacionesValidas();
            $flt_operaciones_tec = Operacion::whereIn('id_operacion', $opeDeUsuario)->orderBy('nombre_operacion')->pluck('nombre_operacion');
        }

        $flt_estados = Estado_hdr::orderBy('id_estado_hdr')->pluck('nombre_estado_hdr');
        $flt_maquinas = Maquinaria::orderBy('alias_maquinaria')->pluck('alias_maquinaria');
        

        $flt_proyectos = collect(DB::select('
                    select s.codigo_servicio
                    from servicio s
                    left join etapa et 
                        on et.id_servicio = s.id_servicio
                    left join orden o 
                        on o.id_etapa = et.id_etapa
                    left join orden_mecanizado om 
                        on om.id_orden = o.id_orden
                    left join hoja_de_ruta hdr 
                        on hdr.id_orden_mecanizado = om.id_orden_mecanizado
                    left join operaciones_de_hdr op_hdr 
                        on op_hdr.id_hoja_de_ruta = hdr.id_hoja_de_ruta
                    group by s.id_servicio, s.codigo_servicio
                '))->pluck('codigo_servicio');

        $flt_tecnicos = $this->obtenerTecnicosDeOperaciones();

        $ishikawa_categorias = Ishikawa_categoria::orderBy('nombre_categoria')->get();
        $ishikawa_causas = Ishikawa_causa::orderBy('nombre_causa')->get();
        $acciones = Accion_para_tarea::orderBy('nombre_accion')->get();
        $zonas = Zona::orderBy('nombre_zona')->get();
        $tareas_mantenimiento = Tarea_mantenimiento::select('tarea_mantenimiento.*', 'tipo_activo_x_tarea_mant.id_tipo_activo', 'activo_x_tarea_mant.id_activo')
        ->orderBy('nombre_tarea')
        ->leftJoin('tipo_activo_x_tarea_mant', 'tipo_activo_x_tarea_mant.id_tarea_mantenimiento', '=', 'tarea_mantenimiento.id_tarea_mantenimiento')
        ->leftJoin('activo_x_tarea_mant', 'activo_x_tarea_mant.id_tarea_mantenimiento', '=', 'tarea_mantenimiento.id_tarea_mantenimiento')        
        ->get();
        
        // $maquinas = Maquinaria::orderBy('alias_maquinaria')->get();
        if (Auth::user()->hasRole('SUPERVISOR') || Auth::user()->hasRole('ADMIN')) {
            $maquinas = Maquinaria::orderBy('alias_maquinaria')->get();
        }else{
            $maquinas = DB::table('maquinaria as maq')
                        ->join('emp_x_maq as exp', 'exp.id_maquinaria', '=', 'maq.id_maquinaria')
                        ->where('exp.id_empleado', Auth::user()->getEmpleado->id_empleado)
                        ->get();
        }
        /*$ordenes_mantenimiento = Orden::join('orden_mantenimiento as om', 'om.id_orden', '=', 'orden.id_orden')
                                ->where('orden.id_etapa', $proyecto->getEtapas->first()->id_etapa)->get();
        $ordenes_mecanizado = Vw_gest_orden_mecanizado::where('id_servicio', $id)->get();
        $estados_mecanizado = Estado_mecanizado::pluck('nombre_estado_mecanizado', 'id_estado_mecanizado');
        $empleados = Empleado::where('esta_activo', 1)->orderBy('nombre_empleado')->get();
 */
        return view('Ingenieria.Servicios.HDR.operaciones.ordenes_mantenimiento', compact('flt_estados', 'flt_maquinas', 'flt_operaciones', 'flt_proyectos', 'flt_operaciones_tec', 'flt_tecnicos',
        'ishikawa_categorias', 'ishikawa_causas', 'acciones', 'zonas', 'maquinas', 'tareas_mantenimiento'
        ));
    }

     public function obtenerTecnicosDeOperaciones(){
        return Empleado::orderBy('nombre_empleado')->activo()->HabilitadoOperacion()->get();
    }

    public function get_operaciones(Request $request){
       //return $request;
       
        $operaciones = Vw_operaciones_de_hdr::orderByRaw('ISNULL(prioridad), prioridad')
            ->orderByRaw('ISNULL(prioridad_servicio), prioridad_servicio')
            ->with('getHdr.getOrdMec');

        $operaciones_mantenimiento = [];
        if((!$request->res || in_array('-', $request->res))){
            $operaciones_mantenimiento = Orden_mantenimiento::with('getEmpleado','getOrden.getEtapa.getServicio.getActivo', 
            'getTipoOrdenMantenimiento');
            if($request->soloAct == 'SI'){
                $operaciones_mantenimiento = $operaciones_mantenimiento->where('esta_activo', 1);
            }            
            $operaciones_mantenimiento = $operaciones_mantenimiento->get()
            ->filter(function ($om) use ($request) {
                $estado = $om->getEstadoActual();
                if($request->est && !in_array($estado, $request->est)){
                    return false;
                }
                if($request->cod_serv && !in_array(
                    $om->getOrden->getEtapa->getServicio->codigo_servicio,
                    $request->cod_serv
                )){
                    return false;
                }
                if($request->sup && !in_array(
                    $om->getTipoOrdenMantenimiento->nombre_tipo_orden_mantenimiento,
                    $request->sup
                )){
                    return false;
                }
                $om->estado_actual = $estado;

                return true;
            })
            ->values();
            foreach($operaciones_mantenimiento as $om){
                $om->horas = $om->getOrden->getHoras();
            }
        }

        if($request->cod_serv){
            $operaciones = $operaciones->whereIn('codigo_servicio', $request->cod_serv);
        }
        if($request->sup){
            $operaciones = $operaciones->whereIn('nombre_operacion', $request->sup);
        }    
        if($request->res){
            if(in_array('-', $request->res)){
                $res = array_diff($request->res, ['-']);
                $operaciones = $operaciones->where(function ($q) use ($res) {
                    if (!empty($res)) {
                        $q->whereIn('codigo_maquinaria', $res)
                        ->orWhereNull('codigo_maquinaria');
                    } else {
                        $q->whereNull('codigo_maquinaria');
                    }
                });
            }else{
                $operaciones = $operaciones->whereIn('codigo_maquinaria', $request->res);
            }                
        }
        if($request->est){
            $operaciones = $operaciones->whereIn('nombre_estado_hdr', $request->est);
        }
        if($request->asig){
            $operaciones = $operaciones->whereIn('tecnico_asignado', $request->asig);
        }
        if($request->soloAct === 'SI'){
            $operaciones = $operaciones->where('activo', 1);
        }

        $operaciones_todas['generales'] = $operaciones->get();
        $operaciones_todas['mantenimiento'] = $operaciones_mantenimiento;
    
    
        return $operaciones_todas;
    }

    public function editar(Request $request){
        $orden_mantenimiento = Orden_mantenimiento::find($request->id_orden);
        if($orden_mantenimiento){
            $orden_mantenimiento->id_empleado = $request->id_empleado;
            if($request->activo){
                $orden_mantenimiento->esta_activo = 1;
            }else{
                $orden_mantenimiento->esta_activo = 0;
            }
            $orden_mantenimiento->save();
            return back()->with(['success' => true, 'mensaje' => 'Orden de mantenimiento actualizada correctamente.']);
        }else{
            return back()->with(['success' => false, 'error' => 'Orden de mantenimiento no encontrada.']);
        }
    }

    public function check_pre_editar(Request $request){
        return Orden_mantenimiento::find($request->id_orden);
    }
}

