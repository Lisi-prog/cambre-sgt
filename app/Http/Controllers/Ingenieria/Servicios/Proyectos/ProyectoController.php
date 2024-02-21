<?php

namespace App\Http\Controllers\Ingenieria\Servicios\Proyectos;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

use App\Models\Cambre\Sol_prioridad_solicitud;
use App\Models\Cambre\Sol_estado_solicitud;
use App\Models\Cambre\Sol_solicitud;
use App\Models\Cambre\Sol_requerimiento_de_ingenieria;
use App\Models\Cambre\Sector;
use App\Models\Cambre\Empleado;
use App\Models\Cambre\Servicio;
use App\Models\Cambre\Subtipo_servicio;
use App\Models\Cambre\Prioridad;
use App\Models\Cambre\Responsabilidad;
use App\Models\Cambre\Rol_empleado;
use App\Models\Cambre\Tipo_servicio;
use App\Models\Cambre\Estado;
use App\Models\Cambre\Etapa;
use App\Models\Cambre\Actualizacion;
use App\Models\Cambre\Actualizacion_servicio;
use App\Models\Cambre\Actualizacion_etapa;
use App\Models\Cambre\Tipo_orden_trabajo;
use App\Models\Cambre\Cambio_de_prioridad;

class ProyectoController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:VER-MENU-PROYECTO', ['only' => ['index']]);
        //  $this->middleware('permission:CREAR-PERMISO', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-PERMISO', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-PERMISO', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {        
        $tipo_servicio = Tipo_servicio::where('nombre_tipo_servicio', 'proyecto')->first();

        if($tipo_servicio){
            foreach ($tipo_servicio->getSubTipos as $subTipo) {
                $id_subtipos[] = $subTipo->id_subtipo_servicio;
            }
            $proyectos = Servicio::whereIn('id_subtipo_servicio', $id_subtipos)->get();
        }else{
            $proyectos = [];
        }
        
        
        
        $empleados = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        $Tipos_servicios = Subtipo_servicio::orderBy('nombre_subtipo_servicio')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        $prioridades = [];
        
        $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        
        return view('Ingenieria.Servicios.Proyectos.index', compact('proyectos', 'empleados', 'Tipos_servicios', 'prioridadMax'));
    }

    public function indexPorTipo(Request $request, $opcion)
    {   
        $tipo_servicio = Tipo_servicio::where('nombre_tipo_servicio', 'proyecto')->first();
        $tipo = Subtipo_servicio::where('id_subtipo_servicio', $opcion)->first();

        if($tipo_servicio){
            $proyectos = Servicio::where('id_subtipo_servicio', $opcion)->get();
        }else{
            $proyectos = [];
        }
        
        $empleados = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        $Tipos_servicios = Subtipo_servicio::orderBy('nombre_subtipo_servicio')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        
        return view('Ingenieria.Servicios.Proyectos.index', compact('proyectos', 'empleados', 'Tipos_servicios', 'prioridadMax', 'tipo'));
    }

    public function create()
    {
        $Tipos_servicios = Subtipo_servicio::orderBy('nombre_subtipo_servicio')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        $Prioridades = Sol_prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->pluck('nombre_prioridad_solicitud', 'id_prioridad_solicitud');
        $empleados = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');

        $prioridades = Prioridad::orderBy('id_prioridad')->pluck('nombre_prioridad', 'id_prioridad');
        // return User::role('SUPERVISOR')->get();
        return view('Ingenieria.Servicios.Proyectos.crear', compact('Prioridades', 'Tipos_servicios', 'empleados', 'prioridades'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'codigo_proyecto' => 'required',
            'nombre_proyecto' => 'required',
            'id_tipo_proyecto' => 'required',
            'lider' => 'required',
            'prioridad' => 'required',
            'fecha_ini' => 'required',
            'fecha_req' => 'required',
            'prioridad' => 'required'
        ],
        [
            'codigo_proyecto.required' => 'Se necesita el codigo del proyecto',
            'nombre_proyecto.required' => 'Se necesita el nombre del proyecto',
            'id_tipo_proyeto.required' => 'Se necesita el tipo del proyecto',
            'lider.required' => 'Se necesita el nombre del proyecto',
            'fecha_ini.required' => 'Se necesita la fecha de inicio',
            'fecha_req.required' => 'Se necesita la fecha requerida',
            'prioridad.required' => 'Se necesita la prioridad'
        ]);
        $codigo_proyecto = $request->input('codigo_proyecto');
        $nombre_proyecto = $request->input('nombre_proyecto');
        $tipo_proyecto = $request->input('id_tipo_proyecto');
        $lider = $request->input('lider');
        $fecha_ini = Carbon::parse($request->input('fecha_ini'))->format('Y-m-d');
        $fecha_req = Carbon::parse($request->input('fecha_req'))->format('Y-m-d');
        // $prioridad = $request->input('prioridad');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'lider')->first();
        $estado = Estado::where('nombre_estado', 'espera')->first();
        // $tipo_servicio = Tipo_servicio::where('nombre_tipo_servicio', 'proyecto')->first();
        $tipo_servicio = $request->input('id_tipo_proyecto');

        // if (Servicio::where('prioridad_servicio', $prioridad)->get()) {
        //     $this->actualizarPrioridades($prioridad);
        // }

        $responsabilidad = Responsabilidad::create([
            // 'id_empleado' => Auth::user()->getEmpleado->id_empleado,
            'id_empleado' => $lider,
            'id_rol_empleado' => $rol_empleado->id_rol_empleado
        ]);
        
        $proyecto = Servicio::create([
            'codigo_servicio' => $codigo_proyecto,
            'nombre_servicio' => $nombre_proyecto,
            'id_subtipo_servicio' => $tipo_servicio,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad,
            'fecha_inicio' => $fecha_ini,
            'prioridad_servicio' => $prioridadMax
        ]);

        $rol_empleado_act = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
        $responsabilidad_act = Responsabilidad::create([
            'id_empleado' => Auth::user()->getEmpleado->id_empleado,
            'id_rol_empleado' => $rol_empleado_act->id_rol_empleado
        ]);

        $actualizacionServicio = Actualizacion::create([
            'descripcion' => 'Creacion de proyecto.',
            'fecha_limite' => $fecha_req,
            'fecha_carga' => $fecha_carga,
            'id_estado' => $estado->id_estado,
            'id_responsabilidad' => $responsabilidad_act->id_responsabilidad
        ]);

        $actualizacion_servicio = Actualizacion_servicio::create([
            'id_actualizacion' => $actualizacionServicio->id_actualizacion,
            'id_servicio' => $proyecto->id_servicio
        ]);

        $etapa = Etapa::create([
            'descripcion_etapa' => 'Creacion de etapa.',
            'fecha_inicio' => $fecha_ini,
            'id_servicio' => $proyecto->id_servicio,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad
        ]);

        $actualizacionEtapa = Actualizacion::create([
            'descripcion' => 'Creacion de etapa.',
            'fecha_limite' => $fecha_req,
            'fecha_carga' => $fecha_carga,
            'id_estado' => $estado->id_estado,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad
        ]);

        $actualizacion_etapa = Actualizacion_etapa::create([
            'id_actualizacion' => $actualizacionEtapa->id_actualizacion,
            'id_etapa' => $etapa->id_etapa
        ]);

        return redirect()->route('proyectos.index')->with('mensaje', 'El proyecto se ha creado con exito.');                      
    }

    public function actualizarPrioridadServicio(Request $request){
        //return $request;
        $this->validate($request, [
            'id_proyecto' => 'required',
            'prioridad' => 'required',
            'motivo' => 'required'
        ],
        [
            'prioridad.required' => 'La prioridad no puede ser nula.',
            'motivo.required' => 'El motivo no puede estar vacio.'
        ]);
        $minima_prioridad = Servicio::max('prioridad_servicio'); //trae el mayor numero asigando actuialmente a las prioridades
        $id_servicio = $request->input('id_proyecto');


        

        $motivo = $request->input('motivo');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        $servicio = Servicio::find($id_servicio);

        //Necesarias para saber entre que valores actualizar
        $prioridadAnterior = $servicio->prioridad_servicio;
        $prioridadActual = $request->input('prioridad');

        if($request->input('prioridad') >= $minima_prioridad){
            if($servicio->prioridad_servicio == $minima_prioridad){
                return redirect()->route('proyectos.index')->with('error', 'La prioridad del proyecto ya es la menor posible');
            }else{
                $prioridad = $minima_prioridad;
            }
        }else{
            $prioridad = $request->input('prioridad');
        }

        $ultima_act = Actualizacion_servicio::where('id_servicio', $servicio->id_servicio)->orderBy('id_actualizacion_servicio', 'desc')->first();

        $act = Actualizacion::create([
            'descripcion' => $motivo.'  ( '.$servicio->prioridad_servicio.' a '.$prioridad.' )',
            'fecha_limite' => $ultima_act->getActualizacion->fecha_limite,
            'fecha_carga' => $fecha_carga,
            'id_estado' => $ultima_act->getActualizacion->id_estado,
            'id_responsabilidad' => $ultima_act->getActualizacion->id_responsabilidad
                ]);

        Actualizacion_servicio::create([
            'id_actualizacion' => $act->id_actualizacion,
            'id_servicio' => $ultima_act->id_servicio
        ]);

        if (Servicio::where('prioridad_servicio', $prioridad)->get()) {
            $this->actualizarPrioridades($prioridadActual, $prioridadAnterior);
        }

        $servicio->update([
            'prioridad_servicio' => $prioridad
        ]);

        return redirect()->route('proyectos.index')->with('mensaje', 'La prioridad del proyecto actualizado exitosamente.');  
    }

    public function actualizarPrioridades($prioridadActual, $prioridadAnterior){
        DB::UPDATE('UPDATE servicio SET prioridad_servicio = prioridad_servicio - 1 WHERE prioridad_servicio <= ? AND prioridad_servicio > ?'  , [$prioridadActual, $prioridadAnterior]);
        DB::UPDATE('UPDATE servicio SET prioridad_servicio = prioridad_servicio + 1 WHERE prioridad_servicio >= ? AND prioridad_servicio < ?', [$prioridadActual, $prioridadAnterior]);
        
    }
    
    public function aceptar_solicitud(Request $request, $id){

        $this->validate($request, [
            'codigo_proyecto' => 'required',
            'nombre_proyecto' => 'required',
            'id_tipo_proyecto' => 'required',
            'lider' => 'required',
            'prioridad' => 'required',
            'fecha_ini' => 'required',
            'fecha_req' => 'required',
            'prioridad' => 'required'
        ],
        [
            'codigo_proyecto.required' => 'Se necesita el codigo del proyecto',
            'nombre_proyecto.required' => 'Se necesita el nombre del proyecto',
            'id_tipo_proyeto.required' => 'Se necesita el tipo del proyecto',
            'lider.required' => 'Se necesita el nombre del proyecto',
            'fecha_ini.required' => 'Se necesita la fecha de inicio',
            'fecha_req.required' => 'Se necesita la fecha requerida',
            'prioridad.required' => 'Se necesita la prioridad'
        ]);

        $id_estado_solicitud = Sol_estado_solicitud::where('nombre_estado_solicitud', 'aceptado')->first()->id_estado_solicitud;

        $solicitud = Sol_solicitud::find($id);

        $solicitud->update([
            'id_estado_solicitud' => $id_estado_solicitud
        ]);

        $codigo_proyecto = $request->input('codigo_proyecto');
        $nombre_proyecto = $request->input('nombre_proyecto');
        $tipo_proyecto = $request->input('id_tipo_proyecto');
        $lider = $request->input('lider');
        $fecha_ini = Carbon::parse($request->input('fecha_ini'))->format('Y-m-d');
        $fecha_req = Carbon::parse($request->input('fecha_req'))->format('Y-m-d');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'lider')->first();
        $estado = Estado::where('nombre_estado', 'espera')->first();
        
        $tipo_servicio = $request->input('id_tipo_proyecto');

        $responsabilidad = Responsabilidad::create([
            'id_empleado' => $lider,
            'id_rol_empleado' => $rol_empleado->id_rol_empleado
        ]);
        
        $proyecto = Servicio::create([
            'codigo_servicio' => $codigo_proyecto,
            'nombre_servicio' => $nombre_proyecto,
            'id_subtipo_servicio' => $tipo_servicio,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad,
            'fecha_inicio' => $fecha_ini,
            'prioridad_servicio' => $prioridadMax
        ]);

        $solicitud->update([
            'id_servicio' => $proyecto->id_servicio
        ]);

        $actualizacionServicio = Actualizacion::create([
            'descripcion' => 'Creacion de proyecto.',
            'fecha_limite' => $fecha_req,
            'fecha_carga' => $fecha_carga,
            'id_estado' => $estado->id_estado,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad
        ]);

        $actualizacion_servicio = Actualizacion_servicio::create([
            'id_actualizacion' => $actualizacionServicio->id_actualizacion,
            'id_servicio' => $proyecto->id_servicio
        ]);

        $etapa = Etapa::create([
            'descripcion_etapa' => 'Creacion de etapa.',
            'fecha_inicio' => $fecha_ini,
            'id_servicio' => $proyecto->id_servicio,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad
        ]);

        $actualizacionEtapa = Actualizacion::create([
            'descripcion' => 'Creacion de etapa.',
            'fecha_limite' => $fecha_req,
            'fecha_carga' => $fecha_carga,
            'id_estado' => $estado->id_estado,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad
        ]);

        $actualizacion_etapa = Actualizacion_etapa::create([
            'id_actualizacion' => $actualizacionEtapa->id_actualizacion,
            'id_etapa' => $etapa->id_etapa
        ]);

        return redirect()->route('proyectos.index')->with('mensaje', 'El proyecto se ha creado con exito.'); 
    }

    public function show($id)
    {
        $proyecto = Servicio::find($id);
        return view('Ingenieria.Servicios.Proyectos.show',compact('proyecto'));
    }
    
    public function obtenerProyecto($id){
        return Servicio::find($id);
    }

    public function edit($id)
    {
        $permiso = Permission::findOrFail($id);
    
        return view('Informatica.GestionUsuarios.permisos.editar',compact('permiso'));
    }
    
    public function update(Request $request, $id)
    {
        //return $request;

        $this->validate($request, [
            'codigo_proyecto' => 'required',
            'nombre_proyecto' => 'required',
            'id_tipo_proyecto' => 'required',
            'lider' => 'required',
            'fecha_inicio' => 'required',
        ]);

        $servicio = Servicio::find($id);

        $codigo = $request->input('codigo_proyecto');

        $nombre = $request->input('nombre_proyecto');

        $tipo = $request->input('id_tipo_proyecto');

        $lider = $request->input('lider');

        $fecha_inicio = $request->input('fecha_inicio');

        $servicio->update([
            'codigo_servicio' => $codigo,
            'nombre_servicio' => $nombre,
            'fecha_inicio' => $fecha_inicio,
            'id_subtipo_servicio' => $tipo,
        ]);


        if ($servicio->getResponsabilidad->getEmpleado->id_empleado != $lider) {
           $res = Responsabilidad::find($servicio->getResponsabilidad->id_responsabilidad);
           $res->id_empleado = $lider;
           $res->save();
        }
    
        return redirect()->route('proyectos.gestionar', $id)->with('mensaje', 'Proyecto editado exitosamente.');                        
    }
    
    public function destroy($id)
    {
        $permiso = Permission::findOrFail($id);

        Permission::destroy($id);

        return redirect()->route('permisos.index')->with('mensaje', 'El permiso se elimino exitosamente.');               
    }

    public function gestionar($id)
    {
        $Tipos_servicios = Subtipo_servicio::orderBy('nombre_subtipo_servicio')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        $proyecto = Servicio::find($id);
        $etapas = $proyecto->getEtapas->pluck('descripcion_etapa', 'id_etapa');
        $empleados = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        $estados = Estado::orderBy('nombre_estado')->pluck('nombre_estado', 'id_estado');
        $tipo_orden = Tipo_orden_trabajo::orderBy('nombre_tipo_orden_trabajo')->pluck('nombre_tipo_orden_trabajo', 'id_tipo_orden_trabajo');
        $supervisores = $this->obtenerSupervisores();
        return view('Ingenieria.Servicios.Proyectos.gestionar',compact('proyecto', 'empleados', 'etapas', 'tipo_orden', 'Tipos_servicios', 'estados', 'supervisores'));
    }

    public function costos($id)
    {
        $Tipos_servicios = Subtipo_servicio::orderBy('nombre_subtipo_servicio')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        $proyecto = Servicio::find($id);
        $etapas = $proyecto->getEtapas->pluck('descripcion_etapa', 'id_etapa');
        $empleados = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        $estados = Estado::orderBy('nombre_estado')->pluck('nombre_estado', 'id_estado');
        $tipo_orden = Tipo_orden_trabajo::orderBy('nombre_tipo_orden_trabajo')->pluck('nombre_tipo_orden_trabajo', 'id_tipo_orden_trabajo');
        return view('Ingenieria.Servicios.Proyectos.costos',compact('proyecto', 'empleados', 'etapas', 'tipo_orden', 'Tipos_servicios', 'estados'));
    }

    public function obtenerActualizacionesServicio($id){

        $actualizaciones_servicio = Actualizacion_servicio::where('id_servicio', $id)->get();
        $actualizacion_arr = array();

        foreach ($actualizaciones_servicio as $act_servicio) {

            array_push($actualizacion_arr, (object)[
                'codigo' => $act_servicio->getActualizacion->id_actualizacion,
                'fecha_carga' => Carbon::parse($act_servicio->getActualizacion->fecha_carga)->format('d-m-Y H:i'),
                'descripcion' => $act_servicio->getActualizacion->descripcion,
                'fecha_limite' => Carbon::parse($act_servicio->getActualizacion->fecha_limite)->format('d-m-Y'),
                'estado' => $act_servicio->getActualizacion->getEstado->nombre_estado,
                'responsable' => $act_servicio->getActualizacion->getResponsable->getEmpleado->nombre_empleado
            ]);

        }

        return $actualizacion_arr;
    }
    
    public function verActualizaciones($id){
        $Tipos_servicios = Subtipo_servicio::orderBy('nombre_subtipo_servicio')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        $proyecto = Servicio::find($id);
        //$etapas = $proyecto->getEtapas->pluck('descripcion_etapa', 'id_etapa');
        $empleados = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        //$tipo_orden = Tipo_orden_trabajo::orderBy('nombre_tipo_orden_trabajo')->pluck('nombre_tipo_orden_trabajo', 'id_tipo_orden_trabajo');
        //$actualizaciones_servicio = $proyecto->getActualizaciones;
        //$actualizaciones = $actualizaciones_servicio->getActualizacion;
        return view('Ingenieria.Servicios.Proyectos.ver-actualizaciones',compact('proyecto', 'empleados', 'Tipos_servicios'));
    }

    public function guardarActualizacion(Request $request, $id){
        
        //return $request;
        $this->validate($request, [
            'descripcion' => 'required',
            'id_estado' => 'required',
            'lider' => 'required',
            'fecha_limite' => 'required'
        ]);

        $descripcion = $request->input('descripcion');

        $id_estado = $request->input('id_estado');

        $fecha_limite = $request->input('fecha_limite');

        $lider = $request->input('lider');

        $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();

        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');

        $responsabilidad = Responsabilidad::create([
            'id_empleado' => Auth::user()->getEmpleado->id_empleado,
            'id_rol_empleado' => $rol_empleado->id_rol_empleado
        ]);

        $actualizacion = Actualizacion::create([
                            'descripcion' => $descripcion,
                            'fecha_limite' => $fecha_limite,
                            'fecha_carga' => $fecha_carga,
                            'id_estado' => $id_estado,
                            'id_responsabilidad' => $responsabilidad->id_responsabilidad
                        ]);

        Actualizacion_servicio::create([
            'id_actualizacion' => $actualizacion->id_actualizacion,
            'id_servicio' => $id
        ]);

        //Actualizamos el lider del proyecto
        $servicio = Servicio::where('id_servicio', $id)->first();
        $responsable_proyecto = $servicio->getResponsabilidad;
        if($responsable_proyecto->id_empleado != $lider){
            $responsable_proyecto->id_empleado = $lider;
            $responsable_proyecto->save();
        }
        return redirect()->route('proyectos.gestionar', $id)->with('mensaje', 'Actualizacion del proyecto creado exitosamente.');  
    }

    public function obtenerSupervisores(){
        $usuariosSupervisor = User::role('SUPERVISOR')->get();

        if ($usuariosSupervisor) {
            foreach ($usuariosSupervisor as $userSupervisor) {
                try {
                    $id_supervisores[] = $userSupervisor->getEmpleado->id_empleado; 
                } catch (\Throwable $th) {
                    $id_supervisores[] = null; 
                }
                  
            }
        }
        return Empleado::whereIn('id_empleado', $id_supervisores)->orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
    }
}