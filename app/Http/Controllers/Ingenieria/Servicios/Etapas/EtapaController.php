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
        $etapas = Etapa::orderBy('id_etapa')->get();
        $empleados = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        return view('Ingenieria.Servicios.Etapas.index', compact('etapas', 'empleados'));
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

        $rol_empleado_act = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
        $responsabilidad_act = Responsabilidad::create([
            'id_empleado' => Auth::user()->getEmpleado->id_empleado,
            'id_rol_empleado' => $rol_empleado_act->id_rol_empleado
        ]);

        $actualizacionEtapa = Actualizacion::create([
            'descripcion' => 'Creacion de etapa.',
            'fecha_limite' => $fecha_ini,
            'fecha_carga' => $fecha_carga,
            'id_estado' => $estado->id_estado,
            'id_responsabilidad' => $responsabilidad_act->id_responsabilidad
        ]);

        $actualizacion_etapa = Actualizacion_etapa::create([
            'id_actualizacion' => $actualizacionEtapa->id_actualizacion,
            'id_etapa' => $etapa->id_etapa
        ]);

        return redirect()->back()->with('mensaje', 'La etapa se ha creado con exito.');                      
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

        return redirect()->back()->with('mensaje', 'La etapa se ha eliminado con exito.');               
    }
    
    public function obtenerActualizacionesEtapa($id){

        $actualizaciones_etapa = Actualizacion_etapa::where('id_etapa', $id)->get();
        $actualizacion_arr = array();

        foreach ($actualizaciones_etapa as $act_etapa) {

            array_push($actualizacion_arr, (object)[
                'codigo' => $act_etapa->getActualizacion->id_actualizacion,
                'fecha_carga' => Carbon::parse($act_etapa->getActualizacion->fecha_carga)->format('d-m-Y H:i'),
                'descripcion' => $act_etapa->getActualizacion->descripcion,
                'fecha_limite' => Carbon::parse($act_etapa->getActualizacion->fecha_limite)->format('d-m-Y'),
                'estado' => $act_etapa->getActualizacion->getEstado->nombre_estado,
                'responsable' => $act_etapa->getActualizacion->getResponsable->getEmpleado->nombre_empleado
            ]);

        }

        return $actualizacion_arr;
    }

    public function gestionar($id)
    {
        $proyecto = Servicio::find($id);
        return view('Ingenieria.Servicios.Proyectos.gestionar',compact('proyecto'));
    }

    public function obtenerUnaEtapa($id){
        $etapa = Etapa::find($id);
        $etapaEspecial = (object)[
            'descripcion_etapa' => $etapa->descripcion_etapa,
            'id_estado' => $etapa->getActualizaciones->sortByDesc('id_actualizacion')->first()->getActualizacion->getEstado->id_estado,
            'estado' => $etapa->getActualizaciones->sortByDesc('id_actualizacion')->first()->getActualizacion->getEstado->nombre_estado,
            'responsable' => $etapa->getResponsable->getEmpleado->nombre_empleado,
            'id_responsable' => $etapa->getResponsable->getEmpleado->id_empleado,
            'fecha_inicio' => $etapa->fecha_inicio,
            'fecha_limite' => $etapa->getActualizaciones->sortByDesc('id_actualizacion')->first()->getActualizacion->fecha_limite,
            'fecha_fin_real' => $etapa->getFechaFinalizacion() ? \Carbon\Carbon::parse($etapa->getFechaFinalizacion())->format('d-m-Y') : '__-__-____',
            'duracion_estimada' => $this->calcularHorasEstimadas($etapa->getOrden),
            'duracion_real' => $etapa->getCalculoHorasReales(),
            'costo_estimado' => $etapa->getCostoEstimado(),
            'costo_real' => $etapa->getCostoReal(),
            'fecha_ultima_actualizacion' => $etapa->getActualizaciones->sortByDesc('id_actualizacion')->first()->getActualizacion->fecha_carga,
        ];
        return $etapaEspecial;
    }

    function actualizarEtapa(Request $request){
        //return $request;
        
        $this->validate($request, [
            'nom_etapa' => 'required',
            'responsable' => 'required',
            'fecha_ini' => 'required'
        ]);

        $id_etapa = $request->input('id_etapa');
        // $id_servicio = $request->input('id_servicio');
        $responsable = $request->input('responsable');
        $fecha_inicio = $request->input('fecha_ini');
        $nombre_etapa = $request->input('nom_etapa');
        $etapa = Etapa::find($id_etapa);
        $descripcion = '';
        
        $etapa->update([
            'descripcion_etapa' => $nombre_etapa,
            'fecha_inicio' => $fecha_inicio
        ]);

        if ($etapa->getResponsable->getEmpleado->id_empleado != $responsable) {
            $ultima_act_etapa = Actualizacion_etapa::where('id_etapa', $id_etapa)->orderBy('id_actualizacion_etapa', 'desc')->first();
            $nuevo_responsable = Empleado::find($responsable);

            $res = Responsabilidad::find($etapa->getResponsable->id_responsabilidad);
            $descripcion = "Se cambio el responsable de la etapa de ".$etapa->getResponsable->getEmpleado->nombre_empleado." a ".$nuevo_responsable->nombre_empleado;
            $res->id_empleado = $responsable;
            $res->save();

            $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();

            $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');

            $responsabilidad = Responsabilidad::create([
                'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                'id_rol_empleado' => $rol_empleado->id_rol_empleado
            ]);

            $actualizacion = Actualizacion::create([
                                'descripcion' => $descripcion,
                                'fecha_limite' => $ultima_act_etapa->getActualizacion->fecha_limite,
                                'fecha_carga' => $fecha_carga,
                                'id_estado' => $ultima_act_etapa->getActualizacion->id_estado,
                                'id_responsabilidad' => $responsabilidad->id_responsabilidad
                            ]);

            Actualizacion_etapa::create([
                'id_actualizacion' => $actualizacion->id_actualizacion,
                'id_etapa' => $id_etapa
            ]);
        }

        return redirect()->back()->with('mensaje', 'Etapa editada exitosamente.');  
    }
    
    function calcularHorasEstimadas($ordenes)
    {
        if(!is_null($ordenes)){
            $horas_estimadas = 0;
            $minutos_estimados = 0;
            foreach ($ordenes as $orden){
                $horas_estimadas += strstr($orden->duracion_estimada, ':', true);
                if (preg_match('/\:(.*?)\:/', $orden->duracion_estimada, $minutosStr)) {
                    $minutos_estimados += $minutosStr[1];
                }
                //$minutos_estimados += substr($orden->duracion_estimada, 3, 2);
                if($minutos_estimados >= 60){
                    $minutos_estimados -= 60;
                    $horas_estimadas += 1;
                }
            }
            if(strlen($horas_estimadas) < 2){
                $horas_estimadas = '0'. $horas_estimadas;
            }
            if(strlen($minutos_estimados) < 2){
                $minutos_estimados = '0'. $minutos_estimados;
            }
            $duracion_estimada = $horas_estimadas . ':' . $minutos_estimados;
            return $duracion_estimada;
        }else{
            return '00:00';
        }
        
    }

    public function verActualizaciones($id){
        $etapa = Etapa::find($id);
        $empleados = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        return view('Ingenieria.Servicios.Etapas.ver-actualizaciones', compact('etapa', 'empleados'));
    }

    public function guardarActualizacion(Request $request, $id){
        return $request;
        $this->validate($request, [
            'm-ver-act-eta-descripcion' => 'required',
            'm-crear-act-eta-idestado' => 'required',
            'm-crear-act-eta-feclimite' => 'required',
            'cbx_responsable_etapa' => 'required',
            'm-crear-act-eta-id_etapa' => 'required'
        ]);

        $descripcion = $request->input('m-ver-act-eta-descripcion');

        $id_estado = $request->input('m-crear-act-eta-idestado');

        $fecha_limite = $request->input('m-crear-act-eta-feclimite');

        $id_etapa = $request->input('m-crear-act-eta-id_etapa');

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

        Actualizacion_etapa::create([
            'id_actualizacion' => $actualizacion->id_actualizacion,
            'id_etapa' => $id_etapa
        ]);
        return redirect()->back()->with('mensaje', 'Actualizacion de la etapa creado exitosamente.');  
    }
}