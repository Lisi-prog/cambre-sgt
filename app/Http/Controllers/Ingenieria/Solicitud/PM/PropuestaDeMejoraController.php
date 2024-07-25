<?php

namespace App\Http\Controllers\Ingenieria\Solicitud\PM;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

use App\Models\Cambre\Sol_prioridad_solicitud;
use App\Models\Cambre\Sol_estado_solicitud;
use App\Models\Cambre\Sol_solicitud;
use App\Models\Cambre\Sol_propuesta_de_mejora;
use App\Models\Cambre\Sector;
use App\Models\Cambre\Empleado;
use App\Models\Cambre\Rol_empleado;
use App\Models\Cambre\Responsabilidad;
use App\Models\Cambre\Activo;
use App\Models\Cambre\Servicio;
use App\Models\Cambre\Subtipo_servicio;
use App\Models\Cambre\Prefijo_proyecto;
use App\Models\Cambre\Estado;
use App\Mail\Solicitud\PmMailable;

class PropuestaDeMejoraController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        //  $this->middleware('permission:VER-PERMISO|CREAR-PERMISO|EDITAR-PERMISO|BORRAR-PERMISO', ['only' => ['index']]);
        //  $this->middleware('permission:CREAR-PERMISO', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-PERMISO', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-PERMISO', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {        
        $ListaPM = Sol_propuesta_de_mejora::get();
        $supervisores = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        $activos = Activo::orderBy('codigo_activo')->whereNotNull('codigo_activo')->pluck('codigo_activo', 'id_activo');

        $flt_users = $this->obtenerEmpleadosActivos();
        // $flt_sectores = Sector::orderBy('nombre_sector')->get();
        // $flt_estados = Sol_estado_solicitud::orderBy('nombre_estado_solicitud')->get();
        $flt_estados = $this->estadosParaSolicitud();
        $flt_estados_sol = Sol_estado_solicitud::orderBy('id_estado_solicitud')->get();
        // $flt_prioridades = Sol_prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->get();

        if (Auth::user()->hasRole('SUPERVISOR') || Auth::user()->hasRole('ADMIN')) {
            return view('Ingenieria.Solicitud.PM.index_su', compact('ListaPM', 'supervisores', 'activos', 'flt_users', 'flt_estados', 'flt_estados_sol'));
        }else{
            return view('Ingenieria.Solicitud.PM.index', compact('ListaPM', 'supervisores', 'activos', 'flt_users', 'flt_estados'));
        }   
    }

    public function obtenerEmpleadosActivos(){
        return Empleado::orderBy('nombre_empleado')->activo()->get();
    }
    
    public function estadosParaSolicitud(){
        $estados_solicitud = Sol_estado_solicitud::orderBy('nombre_estado_solicitud')->get();
        $estados_servicio = Estado::orderBy('nombre_estado')->get();
        $array_estados = [];

        foreach ($estados_solicitud as $estado_solicitud) {
            array_push($array_estados, (object)[
                'nombre_estado_solicitud' => $estado_solicitud->nombre_estado_solicitud
            ]);
        }

        foreach ($estados_servicio as $estado_servicio) {
            array_push($array_estados, (object)[
                'nombre_estado_solicitud' => $estado_servicio->nombre_estado
            ]);
        }

        sort($array_estados);

        return $array_estados;
    }

    public function guardarAlt(Request $request)
    {        
        $this->validate($request, [
            'nombre_completo' => 'required',
            'id_sector' => 'required',
            'descripcion' => 'required',
            'fecha_req' => 'required',
            'id_prioridad' => 'required'
        ]);
        
        $nombre = $request->input('nombre_completo');
        $descrip = $request->input('descripcion');
        $sector = $request->input('id_sector');
        $prioridad = $request->input('id_prioridad');
        $fecha_requerida = Carbon::parse($request->input('fecha_req'))->format('Y-m-d');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        $estado = Sol_estado_solicitud::where('id_estado_solicitud', 1)->first()->id_estado_solicitud;
   
        
        $Solicitud = Sol_solicitud::create([
            'id_prioridad_solicitud' => $prioridad,
            'id_estado_solicitud' => $estado,
            'nombre_solicitante' => $nombre,
            'descripcion_solicitud' => $descrip,
            'fecha_carga' => $fecha_carga,
            'fecha_requerida' => $fecha_requerida
        ]);

        if($request->input('descripcion_urgencia')){
            $Solicitud->update([
                'descripcion_urgencia' => $request->input('descripcion_urgencia')
            ]);
        }

        $Pro_mej = Sol_propuesta_de_mejora::create([
            'id_solicitud' => $Solicitud->id_solicitud,
            'id_empleado' => 1,
            'id_sector' => $sector
        ]);

        //return $Solicitud;
        //$permisos = Permission::orderBy('name', 'asc')->get();
        //$Prioridades = Prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->get();
        return redirect()->route('p_m.index')->with('mensaje', 'Propuesta de mejora creada exitosamente.');
    }
    
    public function evaluar($id){
        $pm = Sol_propuesta_de_mejora::find($id);
        
        $Tipos_servicios = Subtipo_servicio::orderByRaw('FIELD(id_subtipo_servicio, "1", "2", "4", "3", "5", "6")')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        
        $supervisores_user = User::role('SUPERVISOR')->get();

        foreach ($supervisores_user as $supervisor_user) {
            $id_supervisor[] = $supervisor_user->id;
        }

        $empleados = $this->obtenerSupervisoresAdmin();
        $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        $activos = Activo::orderBy('codigo_activo')->whereNotNull('codigo_activo')->pluck('codigo_activo', 'id_activo');
        $prefijos = Prefijo_proyecto::orderBy('nombre_prefijo_proyecto')->pluck('nombre_prefijo_proyecto', 'id_prefijo_proyecto');

        return view('Ingenieria.Solicitud.PM.evaluar',compact('pm', 'activos', 'prioridadMax', 'empleados', 'Tipos_servicios', 'prefijos'));
    }

    public function calificar($id){
        $pm = Sol_propuesta_de_mejora::find($id);
        
        $Tipos_servicios = Subtipo_servicio::orderByRaw('FIELD(id_subtipo_servicio, "1", "2", "4", "3", "5", "6")')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        
        $supervisores_user = User::role('SUPERVISOR')->get();

        foreach ($supervisores_user as $supervisor_user) {
            $id_supervisor[] = $supervisor_user->id;
        }

        $empleados = $this->obtenerSupervisoresAdmin();
        $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        $activos = Activo::orderBy('codigo_activo')->whereNotNull('codigo_activo')->pluck('codigo_activo', 'id_activo');
        $prefijos = Prefijo_proyecto::orderBy('nombre_prefijo_proyecto')->pluck('nombre_prefijo_proyecto', 'id_prefijo_proyecto');

        return view('Ingenieria.Solicitud.PM.calificar',compact('pm', 'activos', 'prioridadMax', 'empleados', 'Tipos_servicios', 'prefijos'));
    }

    public function calificarGuardar($id, Request $request){
        $this->validate($request, [
            'vi_tec' => 'required|numeric|min:1',
            'vi_eco' => 'required|numeric|min:1',
            'vi_temp' => 'required|numeric|min:1',
            'vi_tot' => 'required|numeric|min:1',
            'nece' => 'required|numeric|min:1',
            'inte' => 'required|numeric|min:1',
            'cali' => 'required|numeric|min:1'
        ],
        [
            'vi_tec.min' => 'La viabilidad técnica no puede ser 0.',
            'vi_eco.min' => 'La viabilidad económica no puede ser 0.',
            'vi_temp.min' => 'La viabilidad temporal no puede ser 0.',
            'vi_tot.min' => 'La viabilidad total no puede ser 0.',
            'nece.min' => 'La necesidad no puede ser 0.',  
            'inte.min' => 'El interés no puede ser 0.',
            'cali.min' => 'La calificación no puede ser 0.',
        ]);

        $pm = Sol_propuesta_de_mejora::find($id);

        $pm->update([
            'v_tecnica' => $request->input('vi_tec'),
            'v_economica' => $request->input('vi_eco'),
            'v_temporal' => $request->input('vi_temp'),
            'v_total' => $request->input('vi_tot'),
            'necesidad' => $request->input('nece'),
            'interes' => $request->input('inte'),
            'calificacion' => $request->input('cali')
        ]);
        
        return redirect()->route('p_m.index')->with('mensaje', 'Propuesta de mejora #'.$pm->getSolicitud->id_solicitud.' calificada exitosamente.');
    }

    public function obtenerSupervisoresAdmin(){
        $usuariosSupervisor = User::role(['SUPERVISOR', 'ADMIN'])->get();

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

    public function rechazar($id){
        $solicitud = Sol_solicitud::find($id);
        $solicitud->id_estado_solicitud = 3;
        $solicitud->save();

        try {
            $nombre = $solicitud->getEmpleado->nombre_empleado;
            $codigo = $solicitud->id_solicitud;
            $email = strval(Auth::user()->getEmpleado->email_empleado);
            Mail::to($email)->send(new PmMailable($nombre, $codigo, 3));
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect()->route('p_m.index')->with('mensaje', 'Propuesta de mejora rechazada con exito.');  
    }

    public function create()
    {
        $Prioridades = Sol_prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->pluck('nombre_prioridad_solicitud', 'id_prioridad_solicitud');
        return view('Ingenieria.Solicitud.PM.Crear', compact('Prioridades'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'titulo-propuesta' => 'required',
            'nombre_emisor' => 'required',
            'obj-propuesta' => 'required',
            'desc-propuesta' => 'required',
            'an-i-propuesta' => 'required',
            'bene-propuesta' => 'required',
            'prob-propuesta' => 'required',
            'eva-propuesta' => 'required'
        ], [
            'titulo-propuesta.required' => 'El titulo de la propuesta no puede estar vacio.',
            'nombre_emisor.required' => 'Escriba el nombre del emisor de la propuesta.',
            'obj-propuesta.required' => 'El objetivo de la propuesta no puede estar vacio.'
        ]);

        $titulo = $request->input('titulo-propuesta');
        $lider = Auth::user()->getEmpleado->id_empleado; //$request->input('id_lider');
        $objetivo = $request->input('obj-propuesta');
        $descripcion = $request->input('desc-propuesta');
        $analisis = $request->input('an-i-propuesta');
        $beneficio = $request->input('bene-propuesta');
        $problema = $request->input('prob-propuesta');
        $evaluacion = $request->input('eva-propuesta');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        $nombre_emisor = $request->input('nombre_emisor');
        $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'lider')->first();
        $id_activo = $request->input('id_activo');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        $estado = Sol_estado_solicitud::where('id_estado_solicitud', 1)->first()->id_estado_solicitud;

        $responsabilidad = Responsabilidad::create([
            'id_empleado' => $lider,
            'id_rol_empleado' => $rol_empleado->id_rol_empleado
        ]);

        $solicitud = Sol_solicitud::create([
                        'id_estado_solicitud' => $estado,
                        'nombre_solicitante' => Auth::user()->getEmpleado->nombre_empleado,
                        'fecha_carga' => $fecha_carga,
                        'id_empleado' => Auth::user()->getEmpleado->id_empleado
                    ]);

        $propuestaMejora =  Sol_propuesta_de_mejora::create([
                                'nombre_emisor' => $nombre_emisor,
                                'id_solicitud' => $solicitud->id_solicitud,
                                'id_responsabilidad' => $responsabilidad->id_responsabilidad,
                                'titulo_propuesta' => $titulo,
                                'objetivo_propuesta' => $objetivo,
                                'descripcion_propuesta' => $descripcion,
                                'analisis_propuesta' => $analisis,
                                'beneficio_propuesta' => $beneficio,
                                'problema_propuesta' => $problema,
                                'evaluacion_propuesta' => $evaluacion,
                                'id_activo' => $id_activo
                            ]); 

        
        try {
            $nombre = $solicitud->getEmpleado->nombre_empleado;
            $codigo = $solicitud->id_solicitud;
            $email = strval(Auth::user()->getEmpleado->email_empleado);
            Mail::to($email)->send(new PmMailable($nombre, $codigo, 1));
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        return redirect()->route('p_m.index')->with('mensaje', 'Propuesta de mejora creado exitosamente.');                      
    }
    
    public function show($id)
    {
        $pm = Sol_propuesta_de_mejora::find($id);
        $activos = Activo::orderBy('nombre_activo')->pluck('nombre_activo', 'id_activo');
        return view('Ingenieria.Solicitud.PM.show',compact('pm', 'activos'));
    }
    
    public function edit($id)
    {
        $pm = Sol_propuesta_de_mejora::find($id);
        $activos = Activo::orderBy('nombre_activo')->pluck('nombre_activo', 'id_activo');
        return view('Ingenieria.Solicitud.PM.editar',compact('pm', 'activos'));
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'titulo-propuesta' => 'required',
            'nombre_emisor' => 'required',
            'obj-propuesta' => 'required'
        ], [
            'titulo-propuesta.required' => 'El titulo de la propuesta no puede estar vacio.',
            'nombre_emisor.required' => 'Escriba el nombre del emisor de la propuesta.',
            'obj-propuesta.required' => 'El objetivo de la propuesta no puede estar vacio.'
        ]);

        $pm = Sol_propuesta_de_mejora::find($id);

        $pm->update([
            'id_activo' =>  $request->input('id_activo'),
            'titulo_propuesta' => $request->input('titulo-propuesta'),
            'nombre_emisor' => $request->input('nombre_emisor'),
            'objetivo_propuesta' => $request->input('obj-propuesta')
        ]);

        if (strcmp($request->input('desc-propuesta'), $pm->descripcion_propuesta) !== 0){
            $pm->update([
                    'descripcion_propuesta' =>  $request->input('desc-propuesta')
                ]);
        }

       if (strcmp($request->input('an-i-propuesta'), $pm->analisis_propuesta) !== 0){
            $pm->update([
                    'analisis_propuesta' =>  $request->input('an-i-propuesta')
                ]);
        }

        if (strcmp($request->input('bene-propuesta'), $pm->beneficio_propuesta) !== 0){
            $pm->update([
                    'beneficio_propuesta' =>  $request->input('bene-propuesta')
                ]);
        }

        if (strcmp($request->input('prob-propuesta'), $pm->problema_propuesta) !== 0){
            $pm->update([
                    'problema_propuesta' =>  $request->input('prob-propuesta')
                ]);
        }

        if (strcmp($request->input('eva-propuesta'), $pm->evaluacion_propuesta) !== 0){
            $pm->update([
                    'evaluacion_propuesta' =>  $request->input('eva-propuesta')
                ]);
        }

        return redirect()->route('p_m.index')->with('mensaje', 'Propuesta de mejora editado exitosamente.');                        
    }
    
    public function destroy($id)
    {
        $permiso = Permission::findOrFail($id);

        Permission::destroy($id);

        return redirect()->route('permisos.index')->with('mensaje', 'El permiso se elimino exitosamente.');               
    }

    public function verEvaluar($id){

        $Tipos_servicios = Subtipo_servicio::orderBy('nombre_subtipo_servicio')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        
        $supervisores_user = User::role('SUPERVISOR')->get();

        foreach ($supervisores_user as $supervisor_user) {
            $id_supervisor[] = $supervisor_user->id;
        }

        $empleados = Empleado::whereIn('user_id', $id_supervisor)->orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        $activos = Activo::orderBy('nombre_activo')->pluck('nombre_activo', 'id_activo');

        return view('Ingenieria.Solicitud.PM.evaluar',compact('pm', 'activos', 'prioridadMax', 'empleados'));
    }
}