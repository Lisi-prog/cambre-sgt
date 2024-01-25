<?php

namespace App\Http\Controllers\Ingenieria\Solicitud\SSI;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

use App\Models\Cambre\Sol_prioridad_solicitud;
use App\Models\Cambre\Sol_servicio_de_ingenieria;
use App\Models\Cambre\Sol_estado_solicitud;
use App\Models\Cambre\Sol_solicitud;
use App\Models\Cambre\Sector;
use App\Models\Cambre\Activo;
use App\Models\Cambre\Empleado;
use App\Models\Cambre\Subtipo_servicio;
use App\Models\Cambre\Servicio;

class ServicioDeIngenieriaController extends Controller
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
        $listaSSI = Sol_servicio_de_ingenieria::get();
        $Prioridades = Sol_prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->pluck('nombre_prioridad_solicitud', 'id_prioridad_solicitud');
        $activos = Activo::orderBy('nombre_activo')->pluck('nombre_activo', 'id_activo');
        return view('Ingenieria.Solicitud.SSI.index', compact('listaSSI', 'Prioridades', 'activos'));
    }

    public function create()
    {
        return view('Informatica.GestionUsuarios.permisos.crear');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id_prioridad' => 'required',
            'descripcion' => 'required|string|max:500'
        ]);

        $nombre = Auth::user()->getEmpleado->nombre_empleado;
        $descrip = $request->input('descripcion');
        $prioridad = $request->input('id_prioridad');

        if($request->input('fecha_req')){
            $fecha_requerida = $request->input('fecha_req');
        }else{
            $fecha_requerida = null;
        }
        
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        $estado = Sol_estado_solicitud::where('id_estado_solicitud', 1)->first()->id_estado_solicitud;
        $activo = $request->input('id_activo');
        
        $Solicitud = Sol_solicitud::create([
            'id_prioridad_solicitud' => $prioridad,
            'id_estado_solicitud' => $estado,
            'nombre_solicitante' => $nombre,
            'descripcion_solicitud' => $descrip,
            'fecha_carga' => $fecha_carga,
            'fecha_requerida' => $fecha_requerida,
            'id_empleado' => Auth::user()->getEmpleado->id_empleado
        ]);

        if($request->input('descripcion_urgencia')){
            $Solicitud->update([
                'descripcion_urgencia' => $request->input('descripcion_urgencia')
            ]);
        }

        $Req_ing = Sol_servicio_de_ingenieria::create([
            'id_solicitud' => $Solicitud->id_solicitud,
            'id_activo' => $activo,
            'id_sector' => Auth::user()->getEmpleado->getSector->id_sector
        ]);

        return redirect()->route('s_s_i.index')->with('mensaje', 'Servicio de ingenieria creado con exito.');                    
    }
    
    public function show($id)
    {
        $Ssi = Sol_servicio_de_ingenieria::find($id);
        return view('Ingenieria.Solicitud.SSI.show', compact('Ssi'));
    }
    
    public function edit($id)
    {
        $Ssi = Sol_servicio_de_ingenieria::find($id);
        $activos = Activo::orderBy('nombre_activo')->pluck('nombre_activo', 'id_activo');
        return view('Ingenieria.Solicitud.SSI.editar', compact('Ssi', 'activos'));
    }
    
    public function update(Request $request, $id)
    {
        // return $request;
        $solicitud = Sol_solicitud::find($id);

        $solicitud->update([
            'fecha_requerida' => $request->input('fecha_req'),
            'descripcion_solicitud' => $request->input('descripcion')
        ]);

        if ($request->input('descripcion_urgencia')) {
            $solicitud->update([
                'descripcion_urgencia' => $request->input('descripcion_urgencia')
            ]);
        }
        // Return $solicitud->getServicioDeIngenieria;
        $solicitud->getServicioDeIngenieria->id_activo = $request->input('id_activo');
        $solicitud->getServicioDeIngenieria->save();
        return redirect()->route('s_s_i.index')->with('mensaje', 'Servicio de ingenieria editado exitosamente.');                      
    }
    
    public function evaluar($id){
        $Ssi = Sol_servicio_de_ingenieria::find($id);
        $Tipos_servicios = Subtipo_servicio::orderBy('nombre_subtipo_servicio')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        
        $supervisores_user = User::role('SUPERVISOR')->get();

        foreach ($supervisores_user as $supervisor_user) {
            $id_supervisor[] = $supervisor_user->id;
        }

        $empleados = Empleado::whereIn('user_id', $id_supervisor)->orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        return view('Ingenieria.Solicitud.SSI.Evaluar', compact('Ssi', 'Tipos_servicios', 'empleados', 'prioridadMax'));
    }

    public function rechazar($id){
        $solicitud = Sol_solicitud::find($id);
        $solicitud->id_estado_solicitud = 3;
        $solicitud->save();
        return redirect()->route('s_s_i.index')->with('mensaje', 'Solicitud de servicio de ingenieria rechazada con exito.');  
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