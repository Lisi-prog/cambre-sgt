<?php

namespace App\Http\Controllers\Ingenieria\Solicitud\RI;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

use App\Models\Cambre\Prioridad_solicitud;
use App\Models\Cambre\Estado_solicitud;
use App\Models\Cambre\Solicitud;
use App\Models\Cambre\Requerimiento_de_ingenieria;
use App\Models\Cambre\Sector;
use App\Models\Cambre\Empleado;
use App\Models\Cambre\Servicio;
use App\Models\Cambre\Subtipo_servicio;

class RequerimientoDeIngenieriaController extends Controller
{
    function __construct()
    {
        //$this->middleware('auth');
        //  $this->middleware('permission:VER-PERMISO|CREAR-PERMISO|EDITAR-PERMISO|BORRAR-PERMISO', ['only' => ['index']]);
        //  $this->middleware('permission:CREAR-PERMISO', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-PERMISO', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-PERMISO', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {        
        //$permisos = Permission::orderBy('name', 'asc')->get();
        $ListaRI = Requerimiento_de_ingenieria::get();
        $Prioridades = Prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->pluck('nombre_prioridad_solicitud', 'id_prioridad_solicitud');
        return view('Ingenieria.Solicitud.RI.index', compact('ListaRI', 'Prioridades'));
    }

    public function crearAlt(Request $request)
    {        
        //$permisos = Permission::orderBy('name', 'asc')->get();
        $Prioridades = Prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->pluck('nombre_prioridad_solicitud', 'id_prioridad_solicitud');
        $Sectores = Sector::orderBy('nombre_sector', 'asc')->pluck('nombre_sector', 'id_sector');
        return view('Ingenieria.Solicitud.RI.CrearAlt', compact('Prioridades', 'Sectores'));
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
        $estado = Estado_solicitud::where('id_estado_solicitud', 1)->first()->id_estado_solicitud;
   
        
        $Solicitud = Solicitud::create([
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

        $Req_ing = Requerimiento_de_ingenieria::create([
            'id_solicitud' => $Solicitud->id_solicitud,
            'id_empleado' => 1,
            'id_sector' => $sector
        ]);

        //return $Solicitud;
        //$permisos = Permission::orderBy('name', 'asc')->get();
        //$Prioridades = Prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->get();
        return 'Creado con exito!';
        return view('Ingenieria.Solicitud.ServicioDeIngenieria.CrearAlt', compact('Prioridades'));
        return redirect()->route('permisos.index')->with('mensaje', 'Permiso creado exitosamente.');
    }
    
    public function evaluar($id){
        $Req_ing = Requerimiento_de_ingenieria::find($id);
        $Tipos_servicios = Subtipo_servicio::orderBy('nombre_subtipo_servicio')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        
        $supervisores_user = User::role('SUPERVISOR')->get();

        foreach ($supervisores_user as $supervisor_user) {
            $id_supervisor[] = $supervisor_user->id;
        }

        $empleados = Empleado::whereIn('user_id', $id_supervisor)->orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        return view('Ingenieria.Solicitud.RI.Evaluar', compact('Req_ing', 'Tipos_servicios', 'empleados', 'prioridadMax'));
    }

    public function aceptar(Request $request, $id){

        return $request;
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

        return $this->index();
    }

    public function buscarPermisos(Request $request)
    {        
         //Con paginación
         $permisos = Permission::get();
         return view('Coordinacion.Informatica.GestionUsuarios.permisos.index',compact('permisos'));
         //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!} 
    }

    public function create()
    {
        $Prioridades = Prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->pluck('nombre_prioridad_solicitud', 'id_prioridad_solicitud');
        return view('Ingenieria.Solicitud.RI.Crear', compact('Prioridades'));
    }

    public function store(Request $request)
    {
        // return Auth::user()->getEmpleado;
        $this->validate($request, [
            'id_prioridad' => 'required',
            'descripcion' => 'required|string|max:500'
        ]);

        $nombre = Auth::user()->getEmpleado->nombre_empleado;
        $descrip = $request->input('descripcion');
        $prioridad = $request->input('id_prioridad');

        if($request->input('fecha_req')){
            $fecha_requerida = Carbon::parse($request->input('fecha_req'))->format('Y-m-d');
        }else{
            $fecha_requerida = null;
        }
        
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        $estado = Estado_solicitud::where('id_estado_solicitud', 1)->first()->id_estado_solicitud;
   
        
        $Solicitud = Solicitud::create([
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

        $Req_ing = Requerimiento_de_ingenieria::create([
            'id_solicitud' => $Solicitud->id_solicitud,
            'id_empleado' => Auth::user()->getEmpleado->id_empleado,
            'id_sector' => Auth::user()->getEmpleado->getSector->id_sector
        ]);

        return redirect()->route('r_i.index')->with('mensaje', 'Solicitud de requerimiento de ingenieria creado con exito.');                      
    }
    
    public function show($id)
    {
        $Req_ing = Requerimiento_de_ingenieria::find($id);
        return view('Ingenieria.Solicitud.RI.show', compact('Req_ing'));
    }
    
    public function edit($id)
    {
        $Req_ing = Requerimiento_de_ingenieria::find($id);
    
        return view('Ingenieria.Solicitud.RI.editar', compact('Req_ing'));
    }
    
    public function update(Request $request, $id)
    {
        $solicitud = Solicitud::find($id);

        $solicitud->update([
            'fecha_requerida' => $request->input('fecha_req'),
            'descripcion_solicitud' => $request->input('descripcion')
        ]);

        if ($request->input('descripcion_urgencia')) {
            $solicitud->update([
                'descripcion_urgencia' => $request->input('descripcion_urgencia')
            ]);
        }
    
        return redirect()->route('r_i.index')->with('mensaje', 'Requerimiento de ingenieria editado exitosamente.');                        
    }
    
    public function destroy($id)
    {
        $permiso = Permission::findOrFail($id);

        Permission::destroy($id);

        return redirect()->route('permisos.index')->with('mensaje', 'El permiso se elimino exitosamente.');               
    }

    public function buscarpermisospornombre($nombre){
        return Permission::where('name', 'like', '%'.$nombre.'%')->get();
    }
}