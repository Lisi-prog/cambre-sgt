<?php

namespace App\Http\Controllers\Ingenieria\Activos;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Cambre\Activo;
use App\Models\Cambre\Tipo_activo;
use App\Models\Cambre\Servicio;
use App\Models\Cambre\Rol_empleado;
use App\Models\Cambre\Estado;
use App\Models\Cambre\Responsabilidad;
use App\Models\Cambre\Servicio_info;
use App\Models\Cambre\Actualizacion;
use App\Models\Cambre\Actualizacion_servicio;
use App\Models\Cambre\Etapa;
use App\Models\Cambre\Actualizacion_etapa;
use App\Models\Cambre\Tipo_activo_x_sintoma;
use App\Models\Cambre\Tarea_prev_x_tipo_activo;
use App\Models\Cambre\Activo_x_sintoma;
use App\Models\Cambre\Activo_x_tarea_mant;
use App\Models\Cambre\Tipo_activo_x_tarea_mant;
use App\Models\Cambre\Tarea_prev_x_activo;

class ActivoController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:VER-MENU-ACTIVOS', ['only' => ['index']]);
        //  $this->middleware('permission:CREAR-PERMISO', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-PERMISO', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-PERMISO', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {   
        $activos = Activo::orderBy('id_activo')->get();
        $tipos_activo = Tipo_activo::orderBy('nombre_tipo_activo')->pluck('nombre_tipo_activo','id_tipo_activo');
        return view('Ingenieria.Activos.index', compact('activos', 'tipos_activo'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {         
        $this->validate($request, [
            'codigo_activo' => 'required',
            'nombre_activo' => 'required'
        ]);

        //variables
        $codigo =  strtoupper($request->input('codigo_activo'));
        $nombre = $request->input('nombre_activo');
        $descripcion = $request->input('descripcion');
        $nuevo_serv = $request->input('opt_nsa');
        $esta_activo = $request->input('esta_activo');
        $tipo_activo = $request->input('tipo_activo');
        //-----------------------------------

        //Crear activo
        $activo = Activo::create([
            'codigo_activo' => $codigo,
            'nombre_activo' => $nombre,
            'descripcion_activo' => $descripcion,
            'esta_activo' => $esta_activo,
            'id_tipo_activo' => $tipo_activo
        ]);
        //------------------------------------

        if ($nuevo_serv) {
            $codigo_proyecto = strtoupper($activo->codigo_activo);
            $nombre_proyecto = $activo->codigo_activo;

            $fecha_ini = Carbon::now()->format('Y-m-d');
            $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');

            $prioridadMax = null;
            
            $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'lider')->first();

           
            $estado = Estado::where('nombre_estado', 'Continua')->first();

            $responsabilidad = Responsabilidad::create([
                'id_empleado' => 1,
                // 'id_empleado' => $lider,
                'id_rol_empleado' => $rol_empleado->id_rol_empleado
            ]);
            
            $proyecto = Servicio::create([
                'codigo_servicio' => $codigo_proyecto,
                'nombre_servicio' => $nombre_proyecto,
                'id_subtipo_servicio' => 7,
                'id_responsabilidad' => $responsabilidad->id_responsabilidad,
                'fecha_inicio' => $fecha_ini,
                'prioridad_servicio' => $prioridadMax,
                'id_activo' => $activo->id_activo
            ]);

            Servicio_info::create([
                'id_servicio' => $proyecto->id_servicio, 
                'tot_ord' => 0,
                'tot_ord_completa' => 0,
                'progreso' => 0
            ]);

            $rol_empleado_act = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();

            $responsabilidad_act = Responsabilidad::create([
                'id_empleado' => 1,
                'id_rol_empleado' => $rol_empleado_act->id_rol_empleado
            ]);

            $actualizacionServicio = Actualizacion::create([
                'descripcion' => 'Creacion de proyecto.',
                'fecha_limite' => null,
                'fecha_carga' => $fecha_carga,
                'id_estado' => $estado->id_estado,
                'id_responsabilidad' => $responsabilidad_act->id_responsabilidad
            ]);

            $actualizacion_servicio = Actualizacion_servicio::create([
                'id_actualizacion' => $actualizacionServicio->id_actualizacion,
                'id_servicio' => $proyecto->id_servicio
            ]);

            $etapa = Etapa::create([
                'descripcion_etapa' => $nombre_proyecto,
                'fecha_inicio' => $fecha_ini,
                'id_servicio' => $proyecto->id_servicio,
                'id_responsabilidad' => $responsabilidad->id_responsabilidad
            ]);

            $actualizacionEtapa = Actualizacion::create([
                'descripcion' => 'Creacion de etapa.',
                'fecha_limite' => null,
                'fecha_carga' => $fecha_carga,
                'id_estado' => $estado->id_estado,
                'id_responsabilidad' => $responsabilidad->id_responsabilidad
            ]);

            $actualizacion_etapa = Actualizacion_etapa::create([
                'id_actualizacion' => $actualizacionEtapa->id_actualizacion,
                'id_etapa' => $etapa->id_etapa
            ]);
        }

        return redirect()->route('activos.index')->with('mensaje', 'Activo creado exitosamente.');             
    }
    
    public function show($id)
    {
    }
    
    public function edit($id)
    {
        $activo = Activo::find($id);
        $tipos_activo = Tipo_activo::orderBy('nombre_tipo_activo')->pluck('nombre_tipo_activo','id_tipo_activo');
        return view('Ingenieria.Activos.editar', compact('activo', 'tipos_activo'));
    }
    
    public function update(Request $request, $id)
    {             
        $this->validate($request, [
            'codigo_activo' => 'required',
            'nombre_activo' => 'required'
        ]);    
        
        //variables
        $nombre = $request->input('nombre_activo');
        $codigo =  strtoupper($request->input('codigo_activo'));
        $esta_activo = $request->input('esta_activo');
        $tipo_activo = $request->input('tipo_activo');
        $nuevo_serv = $request->input('opt_nsa');
        //-----------------------------------

        $activo = Activo::find($id);

        $activo->update([
            'codigo_activo' => $codigo,
            'nombre_activo' => $nombre,
            'esta_activo' => $esta_activo,
            'id_tipo_activo' => $tipo_activo
        ]);

        if ($request->input('descripcion')) {
            $activo->update([
                'descripcion_activo' => $request->input('descripcion')
            ]);
        }

        if ($nuevo_serv) {
            $codigo_proyecto = strtoupper($activo->codigo_activo);
            $nombre_proyecto = $activo->codigo_activo;

            $fecha_ini = Carbon::now()->format('Y-m-d');
            $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');

            $prioridadMax = null;
            
            $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'lider')->first();

           
            $estado = Estado::where('nombre_estado', 'Continua')->first();

            $responsabilidad = Responsabilidad::create([
                'id_empleado' => 1,
                // 'id_empleado' => $lider,
                'id_rol_empleado' => $rol_empleado->id_rol_empleado
            ]);
            
            $proyecto = Servicio::create([
                'codigo_servicio' => $codigo_proyecto,
                'nombre_servicio' => $nombre_proyecto,
                'id_subtipo_servicio' => 7,
                'id_responsabilidad' => $responsabilidad->id_responsabilidad,
                'fecha_inicio' => $fecha_ini,
                'prioridad_servicio' => $prioridadMax,
                'id_activo' => $activo->id_activo
            ]);

            Servicio_info::create([
                'id_servicio' => $proyecto->id_servicio, 
                'tot_ord' => 0,
                'tot_ord_completa' => 0,
                'progreso' => 0
            ]);

            $rol_empleado_act = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();

            $responsabilidad_act = Responsabilidad::create([
                'id_empleado' => 1,
                'id_rol_empleado' => $rol_empleado_act->id_rol_empleado
            ]);

            $actualizacionServicio = Actualizacion::create([
                'descripcion' => 'Creacion de proyecto.',
                'fecha_limite' => null,
                'fecha_carga' => $fecha_carga,
                'id_estado' => $estado->id_estado,
                'id_responsabilidad' => $responsabilidad_act->id_responsabilidad
            ]);

            $actualizacion_servicio = Actualizacion_servicio::create([
                'id_actualizacion' => $actualizacionServicio->id_actualizacion,
                'id_servicio' => $proyecto->id_servicio
            ]);

            $etapa = Etapa::create([
                'descripcion_etapa' => $nombre_proyecto,
                'fecha_inicio' => $fecha_ini,
                'id_servicio' => $proyecto->id_servicio,
                'id_responsabilidad' => $responsabilidad->id_responsabilidad
            ]);

            $actualizacionEtapa = Actualizacion::create([
                'descripcion' => 'Creacion de etapa.',
                'fecha_limite' => null,
                'fecha_carga' => $fecha_carga,
                'id_estado' => $estado->id_estado,
                'id_responsabilidad' => $responsabilidad->id_responsabilidad
            ]);

            $actualizacion_etapa = Actualizacion_etapa::create([
                'id_actualizacion' => $actualizacionEtapa->id_actualizacion,
                'id_etapa' => $etapa->id_etapa
            ]);
        }

        return redirect()->route('activos.index')->with('mensaje', 'Activo editado exitosamente.');           
    }
    
    public function destroy($id)
    {      
        Activo::destroy($id);

        return redirect()->route('activos.index')->with('mensaje', 'El activo se elimino exitosamente.');         
    }

    public function tipo_activo_index(Request $request){
        $tipos_activo = Tipo_activo::orderBy('nombre_tipo_activo')->get();
        return view('Ingenieria.Activos.Tipo_activo.index', compact('tipos_activo'));
    }

    public function tipo_activo_store(Request $request){

        $this->validate($request, [
            'tipo_activo' => 'required',
        ]); 

        $tipo = $request->input('tipo_activo');

        Tipo_activo::create([
            'nombre_tipo_activo' => $tipo
        ]);

        return redirect()->route('tipo_activo.index')->with('mensaje', 'El tipo activo creado exitosamente.');
    }

    public function tipo_activo_edit($id){
        $ta = Tipo_activo::find($id);
        return view('Ingenieria.Activos.Tipo_activo.edit', compact('ta'));
    }

    public function tipo_activo_update(Request $request, $id){
        $ta = Tipo_activo::find($id);

        $tipo = $request->input('tipo_activo');

        $ta->update([
            'nombre_tipo_activo' => $tipo
        ]);

        return redirect()->route('tipo_activo.index')->with('mensaje', 'El tipo activo editado exitosamente.');
    }

    public function tipo_activo_destroy($id){
        Tipo_activo::destroy($id);

        return redirect()->route('tipo_activo.index')->with('mensaje', 'El tipo activo se elimino exitosamente.'); 
    }

    //-- Gestión de síntomas --//

    public function set_sintomas_activo(Request $request){
        $activo = Activo::findOrFail($request->input('id_activo'));
        $activo->setSintomas($request->input('sintomas', []));
        return redirect()->back()->with('mensaje','Síntomas asignados al activo exitosamente.');
    }

    public function destroy_sintoma_activo($id_sintoma, $id_activo){
        $activo_x_sintoma = Activo_x_sintoma::where('id_sintoma', $id_sintoma)->where('id_activo', $id_activo)->first();
        if ($activo_x_sintoma) {
            $activo_x_sintoma->delete();
        }
        return redirect()->back()->with('mensaje','Síntoma eliminado del activo exitosamente.');
    }

    public function set_sintomas_tipo_activo(Request $request){
        $tipo_activo = Tipo_activo::findOrFail($request->input('id_tipo_activo'));
        $tipo_activo->setSintomas($request->input('sintomas', []));
        return redirect()->back()->with('mensaje','Síntomas asignados al tipo de activo exitosamente.');
    }

    public function destroy_sintoma_tipo_activo($id_sintoma, $id_tipo_activo){
        $tipo_activo_x_sintoma = Tipo_activo_x_sintoma::where('id_sintoma', $id_sintoma)->where('id_tipo_activo', $id_tipo_activo)->first();
        if ($tipo_activo_x_sintoma) {
            $tipo_activo_x_sintoma->delete();
        }
        return redirect()->back()->with('mensaje','Síntoma eliminado del tipo de activo exitosamente.');
    }

    //-- Gestión de tareas de Mantenimiento --//

    public function set_tareas_mantenimiento_activo(Request $request){
        $activo = Activo::findOrFail($request->input('id_activo'));
        $activo->setTareasMantenimiento($request->input('tareas_mantenimiento', []));
        return redirect()->back()->with('mensaje','Tareas de mantenimiento asignadas al activo exitosamente.');
    }
   public function set_tareas_mantenimiento_preventiva_activo(Request $request)
    {
        $id_activo = $request->id_activo;
        $tareas = $request->tareas_mantenimiento ?? [];

        foreach ($tareas as $id_tarea) {
            $intervalo = $request->input('duracion_' . $id_tarea);
            $cant_golpes = $request->input('cant_golpes_' . $id_tarea);
            $fecha = $request->input('fecha_ultima_ejecucion_' . $id_tarea);

            Tarea_prev_x_activo::create([
                'id_activo' => $id_activo,
                'id_tarea_mantenimiento' => $id_tarea,
                'intervalo_dias' => $intervalo,
                'cant_golpes' => $cant_golpes,
                'fecha_ultima_ejecucion' => $fecha,
            ]);
        }

        return redirect()->back()->with('success', 'Tareas preventivas asignadas correctamente.');
    }

    public function destroy_tarea_mantenimiento_activo($id_tarea_mant, $id_activo){
        $activo_x_tarea_mant = Activo_x_tarea_mant::where('id_tarea_mantenimiento', $id_tarea_mant)->where('id_activo', $id_activo)->first();
        if ($activo_x_tarea_mant) {
            $activo_x_tarea_mant->delete();
        }
        return redirect()->back()->with('mensaje','Tarea de mantenimiento eliminada del activo exitosamente.');
    }

    public function destroy_tarea_mantenimiento_preventiva_activo($id_tarea_mant, $id_activo){
        $activo_x_tarea_mant = Tarea_prev_x_activo::where('id_tarea_mantenimiento', $id_tarea_mant)->where('id_activo', $id_activo)->first();
        if ($activo_x_tarea_mant) {
            $activo_x_tarea_mant->delete();
        }
        return redirect()->back()->with('mensaje','Tarea de mantenimiento eliminada del activo exitosamente.');
    }

    public function set_tareas_mantenimiento_tipo_activo(Request $request){
        $tipo_activo = Tipo_activo::findOrFail($request->input('id_tipo_activo'));
        $tipo_activo->setTareasMantenimiento($request->input('tareas_mantenimiento', []));
        return redirect()->back()->with('mensaje','Tareas de mantenimiento asignadas al tipo de activo exitosamente.');
    }

    public function set_tareas_mantenimiento_preventivas_tipo_activo(Request $request){
        $id_tipo_activo = $request->id_tipo_activo;
        $tareas = $request->tareas_mantenimiento ?? [];

        foreach ($tareas as $id_tarea) {

            $intervalo = $request->input('duracion_' . $id_tarea);
            $cant_golpes = $request->input('cant_golpes_' . $id_tarea);
            $fecha = $request->input('fecha_ultima_ejecucion_' . $id_tarea);

            Tarea_prev_x_tipo_activo::create(
                [
                    'id_tipo_activo' => $id_tipo_activo,
                    'id_tarea_mantenimiento' => $id_tarea,
                    'intervalo_dias' => $intervalo,
                    'cant_golpes' => $cant_golpes,
                    'fecha_ultima_ejecucion' => $fecha,
                ]
            );
        }

        return redirect()->back()->with('success', 'Tareas preventivas asignadas correctamente.');
    }

    

    public function destroy_tarea_mantenimiento_tipo_activo($id_tarea_mant, $id_tipo_activo){
        $tipo_activo_x_tarea_mant = Tipo_activo_x_tarea_mant::where('id_tarea_mantenimiento', $id_tarea_mant)->where('id_tipo_activo', $id_tipo_activo)->first();
        if ($tipo_activo_x_tarea_mant) {
            $tipo_activo_x_tarea_mant->delete();
        }
        return redirect()->back()->with('mensaje','Tarea de mantenimiento eliminada del tipo de activo exitosamente.');
    }

    public function destroy_tarea_mantenimiento_preventiva_tipo_activo($id_tarea_mant, $id_tipo_activo){
        $tipo_activo_x_tarea_mant = Tarea_prev_x_tipo_activo::where('id_tarea_mantenimiento', $id_tarea_mant)->where('id_tipo_activo', $id_tipo_activo)->first();
        if ($tipo_activo_x_tarea_mant) {
            $tipo_activo_x_tarea_mant->delete();
        }
        return redirect()->back()->with('mensaje','Tarea de mantenimiento eliminada del tipo de activo exitosamente.');
    }
}