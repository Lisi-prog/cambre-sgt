<?php

namespace App\Http\Controllers\Ingenieria\Servicios\Etapas;
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
use App\Models\Cambre\Prioridad;
use App\Models\Cambre\Responsabilidad;
use App\Models\Cambre\Rol_empleado;
use App\Models\Cambre\Tipo_servicio;
use App\Models\Cambre\Estado;
use App\Models\Cambre\Etapa;
use App\Models\Cambre\Actualizacion;
use App\Models\Cambre\Actualizacion_servicio;
use App\Models\Cambre\Actualizacion_etapa;

class EtapaController extends Controller
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
        $tipo_servicio = Tipo_servicio::where('nombre_tipo_servicio', 'proyecto')->first();

        foreach ($tipo_servicio->getSubTipos as $subTipo) {
            $id_subtipos[] = $subTipo->id_subtipo_servicio;
        }

        $proyectos = Servicio::whereIn('id_subtipo_servicio', $id_subtipos)->get();

        return view('Ingenieria.Servicios.Proyectos.index', compact('proyectos'));
    }

    public function create()
    {
        $Tipos_servicios = Subtipo_servicio::orderBy('nombre_subtipo_servicio')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        $Prioridades = Prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->pluck('nombre_prioridad_solicitud', 'id_prioridad_solicitud');
        $empleados = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');

        $prioridades = Prioridad::orderBy('id_prioridad')->pluck('nombre_prioridad', 'id_prioridad');
        // return User::role('SUPERVISOR')->get();
        return view('Ingenieria.Servicios.Proyectos.crear', compact('Prioridades', 'Tipos_servicios', 'empleados', 'prioridades'));
    }

    public function store(Request $request)
    {
                             
        $this->validate($request, [
            'nom_etapa' => 'required',
            'responsable' => 'required',
            'fecha_ini' => 'required',
            'id_servicio' => 'required'
        ]);
        
        $nombre_etapa = $request->input('nom_etapa');
        $responsable = $request->input('responsable');
        $servicio = $request->input('id_servicio');
        $fecha_ini = Carbon::parse($request->input('fecha_ini'))->format('Y-m-d');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');

        $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
        $estado = Estado::where('nombre_estado', 'espera')->first();

        $responsabilidad = Responsabilidad::create([
            'id_empleado' => $responsable,
            'id_rol_empleado' => $rol_empleado->id_rol_empleado
        ]);

        $etapa = Etapa::create([
            'descripcion_etapa' => $nombre_etapa,
            'fecha_inicio' => $fecha_ini,
            'id_servicio' => $servicio,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad,
        ]);

        $actualizacionEtapa = Actualizacion::create([
            'descripcion' => 'Creacion de etapa.',
            'fecha_limite' => $fecha_ini,
            'fecha_carga' => $fecha_carga,
            'id_estado' => $estado->id_estado,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad
        ]);

        $actualizacion_etapa = Actualizacion_etapa::create([
            'id_actualizacion' => $actualizacionEtapa->id_actualizacion,
            'id_etapa' => $etapa->id_etapa
        ]);

        return redirect()->route('proyectos.gestionar', $servicio)->with('mensaje', 'La etapa se ha creado con exito.');                      
    }
    
    public function show($id)
    {
        $proyecto = Servicio::find($id);
        return view('Ingenieria.Servicios.Proyectos.show',compact('proyecto'));
    }
    
    public function edit($id)
    {
        $permiso = Permission::findOrFail($id);
    
        return view('Informatica.GestionUsuarios.permisos.editar',compact('permiso'));
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
    
        $permiso = Permission::find($id);

        $permiso->update([
            'name' => strtoupper($request->input('name'))
        ]);
    
        return redirect()->route('permisos.index')->with('mensaje',$permiso->name.' editado exitosamente.');                        
    }
    
    public function destroy($id)
    {
        $permiso = Etapa::findOrFail($id);

        $servicio = $permiso->id_servicio;

        $act_etapa = Actualizacion_etapa::where('id_etapa', $id)->get();
        
        foreach ($act_etapa as $una_act_etapa) {
            $id_actualizacion = $una_act_etapa->id_actualizacion;
            Actualizacion_etapa::destroy($una_act_etapa->id_actualizacion_etapa);
            Actualizacion::destroy($id_actualizacion);
        }

        Etapa::destroy($id);

        return redirect()->route('proyectos.gestionar', $servicio)->with('mensaje', 'La etapa se ha eliminado con exito.');               
    }

    public function gestionar($id)
    {
        $proyecto = Servicio::find($id);
        return view('Ingenieria.Servicios.Proyectos.gestionar',compact('proyecto'));
    }

}