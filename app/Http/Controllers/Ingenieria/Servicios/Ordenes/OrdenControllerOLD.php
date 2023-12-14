<?php

namespace App\Http\Controllers\Ingenieria\Servicios\Ordenes;
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
use App\Models\Cambre\Orden_trabajo;
use App\Models\Cambre\Parte_trabajo;

class OrdenController extends Controller
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
        $ordenes_trabajo = Orden_trabajo::orderBy('id_orden_trabajo')->get();
        return view('Ingenieria.Servicios.Ordenes.index', compact('ordenes_trabajo'));
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
            'codigo_orden' => 'required',
            'nombre_orden' => 'required',
            'id_tipo_orden' => 'required',
            'lider' => 'required',
            'fecha_ini' => 'required',
            'fecha_req' => 'required',
            'prioridad' => 'required'
        ]);
        
        $codigo_orden = $request->input('codigo_orden');
        $nombre_orden = $request->input('nombre_orden');
        $tipo_orden = $request->input('id_tipo_orden');
        $lider = $request->input('lider');
        $fecha_ini = Carbon::parse($request->input('fecha_ini'))->format('Y-m-d');
        $fecha_req = Carbon::parse($request->input('fecha_req'))->format('Y-m-d');
        $prioridad = $request->input('prioridad');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        
        $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'lider')->first();
        $estado = Estado::where('nombre_estado', 'espera')->first();
        // $tipo_servicio = Tipo_servicio::where('nombre_tipo_servicio', 'orden')->first();
        $tipo_servicio = $request->input('id_tipo_orden');

        $responsabilidad = Responsabilidad::create([
            // 'id_empleado' => Auth::user()->getEmpleado->id_empleado,
            'id_empleado' => $lider,
            'id_rol_empleado' => $rol_empleado->id_rol_empleado
        ]);
        
        $orden = Servicio::create([
            'codigo_servicio' => $codigo_orden,
            'nombre_servicio' => $nombre_orden,
            'id_subtipo_servicio' => $tipo_servicio,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad,
            'fecha_inicio' => $fecha_ini,
            'id_prioridad' => $prioridad
        ]);

        $actualizacionServicio = Actualizacion::create([
            'descripcion' => 'Creacion de orden.',
            'fecha_limite' => $fecha_req,
            'fecha_carga' => $fecha_carga,
            'id_estado' => $estado->id_estado,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad
        ]);

        $actualizacion_servicio = Actualizacion_servicio::create([
            'id_actualizacion' => $actualizacionServicio->id_actualizacion,
            'id_servicio' => $orden->id_servicio
        ]);

        $etapa = Etapa::create([
            'descripcion_etapa' => 'Creacion de etapa.',
            'fecha_inicio' => $fecha_ini,
            'id_servicio' => $orden->id_servicio,
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

        return redirect()->route('ordenes.index')->with('mensaje', 'La orden se ha creado con exito.');                      
    }
    
    public function show($id)
    {
        $orden = Servicio::find($id);
        return view('Ingenieria.Servicios.Ordenes.show',compact('orden'));
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
        $permiso = Permission::findOrFail($id);

        Permission::destroy($id);

        return redirect()->route('permisos.index')->with('mensaje', 'El permiso se elimino exitosamente.');               
    }

    public function gestionar($id)
    {
        $orden = Servicio::find($id);
        $empleados = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        return view('Ingenieria.Servicios.Ordenes.gestionar',compact('orden', 'empleados'));
    }

    public function crearOrden(Request $request)
    {
        // return $request;
        $tipo_orden = $request->input('tipo_orden');
        $servicio = $request->input('id_servicio');
        switch ($tipo_orden) {
            case 1:
                # Crear orden de trabajo
                $this->validate($request, [
                    'num_etapa' => 'required',
                    'nom_orden' => 'required',
                    'tipo_orden_trabajo' => 'required',
                    'responsable' => 'required',
                    'fecha_ini' => 'required',
                    'fecha_req' => 'required'
                ]);

                $id_etapa = $request->input('num_etapa');
                $nombre_orden = $request->input('nom_orden');
                $tipo_orden_trabajo = $request->input('tipo_orden_trabajo');
                $id_responsable = $request->input('responsable');
                $fecha_ini = Carbon::parse($request->input('fecha_ini'))->format('Y-m-d');
                $fecha_req = Carbon::parse($request->input('fecha_req'))->format('Y-m-d');
                $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');

                $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
                $estado = Estado::where('nombre_estado', 'en proceso')->first();

                $responsabilidad = Responsabilidad::create([
                    'id_empleado' => $id_responsable,
                    'id_rol_empleado' => $rol_empleado->id_rol_empleado
                ]);

                $orden_trabajo = Orden_trabajo::create([
                    'nombre_orden_trabajo' => $nombre_orden,
                    'id_etapa' => $id_etapa,
                    'id_tipo_orden_trabajo' => $tipo_orden_trabajo,
                    'id_responsabilidad' => $responsabilidad->id_responsabilidad
                ]);

                Parte_trabajo::create([
                    'observacion' => 'Generacion de orden de trabajo',
                    'fecha' => $fecha_ini,
                    'fecha_limite' => $fecha_req,
                    'fecha_carga' => $fecha_carga,
                    'horas' => '00:00',
                    'id_estado' => $estado->id_estado,
                    'id_orden_trabajo' => $orden_trabajo->id_orden_trabajo,
                    'id_responsabilidad' => $responsabilidad->id_responsabilidad
                ]);
                return redirect()->route('proyectos.gestionar', $servicio)->with('mensaje', 'La orden de trabajo y el parte de trabajo se ha creado con exito.'); 
                break;
            
            default:
                # code...
                break;
        }
    }

    public function obtenerOrdenesDeUnaEtapa($id){
        $etapa = Etapa::find($id);
        $ordenes = array();

        foreach ($etapa->getOrdenTrabajo as $orden_trabajo) {
            array_push($ordenes, (object)[
                'id_orden' => $orden_trabajo->id_orden_trabajo,
                'orden' => $orden_trabajo->nombre_orden_trabajo,
                'tipo' => 'Orden de trabajo',]);
        }
        return $ordenes;
    }

    public function ObtenerOrdenTrabajo($id){
        $orden_trabajo = Orden_trabajo::find($id);
        $orden_trabajo_arr = array();

        array_push($orden_trabajo_arr, (object)[
            'id_orden' => $orden_trabajo->id_orden_trabajo,
            'orden' => $orden_trabajo->nombre_orden_trabajo,
            'tipo' => $orden_trabajo->getTipoOrdenTrabajo->nombre_tipo_orden_trabajo,
            'estado' => $orden_trabajo->getPartes->sortByDesc('id_parte_trabajo')->first()->getEstado->nombre_estado,
            'responsable' => $orden_trabajo->getResponsable->getEmpleado->nombre_empleado,
            'fecha_inicio' => Carbon::parse($orden_trabajo->getPartes->sortBy('id_parte_trabajo')->first()->fecha)->format('d-m-Y'),
            'fecha_limite' => Carbon::parse($orden_trabajo->getPartes->sortByDesc('id_parte_trabajo')->first()->fecha_limite)->format('d-m-Y'),
            'fecha_fin_real' => '+late',
            'duracion_estimada' => '00:00',
            'duracion_real' => '00:00',
            'fecha_ultimo_parte' => Carbon::parse($orden_trabajo->getPartes->sortByDesc('id_parte_trabajo')->first()->fecha_carga)->format('d-m-Y'),
            'descripcion_ultimo_parte' => $orden_trabajo->getPartes->sortByDesc('id_parte_trabajo')->first()->observacion,
            'supervisa' => $orden_trabajo->getPartes->sortByDesc('id_parte_trabajo')->first()->getResponsable->getEmpleado->nombre_empleado
            ]);
        
        return $orden_trabajo_arr;
    }

    public function verOrdenModal($id)
    {
        $orden = Orden::find($id);
        return $orden;
    }
}