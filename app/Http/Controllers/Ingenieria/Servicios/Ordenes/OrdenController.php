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
use App\Models\Cambre\Responsabilidad_orden;
use App\Models\Cambre\Rol_empleado;
use App\Models\Cambre\Tipo_servicio;
use App\Models\Cambre\Estado;
use App\Models\Cambre\Estado_mecanizado;
use App\Models\Cambre\Etapa;
use App\Models\Cambre\Actualizacion;
use App\Models\Cambre\Actualizacion_servicio;
use App\Models\Cambre\Actualizacion_etapa;
use App\Models\Cambre\Orden;
use App\Models\Cambre\Orden_trabajo;
use App\Models\Cambre\Parte_trabajo;
use App\Models\Cambre\Parte;
use App\Models\Cambre\Tipo_orden_trabajo;
use App\Models\Cambre\Orden_mecanizado;
use App\Models\Cambre\Parte_mecanizado;

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
        if (Auth::user()->hasRole('SUPERVISOR')) {
            $ordenes_trabajo = Orden::orderBy('id_orden')->get();
            return view('Ingenieria.Servicios.Ordenes.index', compact('ordenes_trabajo'));
        } else {
            $ordenes_trabajo = Orden::orderBy('id_orden')->get();
            return view('Ingenieria.Servicios.Ordenes.index-emp', compact('ordenes_trabajo'));
        }   
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
        //return $request;
        $tipo_orden = $request->input('tipo_orden');
        $servicio = $request->input('id_servicio');
        switch ($tipo_orden) {
            case 1:
                # Crear orden de trabajo
                $this->validate($request, [
                    'num_etapa' => 'required',
                    'nom_orden' => 'required',
                    'horas_estimadas' => 'required',
                    'minutos_estimados' => 'required',
                    'tipo_orden_trabajo' => 'required',
                    'responsable' => 'required',
                    'supervisor' => 'required',
                    'fecha_ini' => 'required',
                    'id_estado' => 'required',
                    'fecha_req' => 'required'
                ], [
                    'horas_estimadas.required' => 'Faltan las horas estimadas'
                ]);

                $this->crearOrdenTrabajo($request);
                
                return redirect()->route('proyectos.gestionar', $servicio)->with('mensaje', 'La orden de trabajo y el parte de trabajo se ha creado con exito.'); 
                break;
            case 3:
                # Crear orden de mecanizado
                $this->validate($request, [
                    'num_etapa' => 'required',
                    'nom_orden' => 'required',
                    'horas_estimadas' => 'required',
                    'minutos_estimados' => 'required',
                    'responsable' => 'required',
                    'fecha_ini' => 'required',
                    'estado_mecanizado' => 'required',
                    'fecha_req' => 'required',
                    'ruta_plano' => 'required'
                ], [
                    'num_etapa.required' => 'Seleccione una etapa.',
                    'nom_orden.required' => 'Falta el nombre de la orden.',
                    'horas_estimadas.required' => 'Faltan las horas estimadas.',
                    'minutos_estimados.required' => 'Faltan los minutos estimados.',
                    'responsable.required' => 'Seleccione un responsable',
                    'fecha_ini.required' => 'Seleccione una fecha de inicio.',
                    'estado_mecanizado.required' => 'Seleccione una etapa.',
                    'fecha_req.required' => 'Seleccione una fecha limite.',
                    'ruta_plano.required' => 'Falta la ruta del plano.'
                ]);

                $this->crearOrdenMecanizado($request);

                return redirect()->route('proyectos.gestionar', $servicio)->with('mensaje', 'La orden de mecanizado y el parte de mecanizado se ha creado con exito.'); 
                break;
            
            default:
                # code...
                break;
        }
    }

    public function crearOrdenTrabajo($request){
        $id_etapa = $request->input('num_etapa');
        $nombre_orden = $request->input('nom_orden');
        $duracion_estimada = $request->input('horas_estimadas') . ':' . $request->input('minutos_estimados');
        $tipo_orden_trabajo = $request->input('tipo_orden_trabajo');
        $id_responsable = $request->input('responsable');
        $fecha_ini = Carbon::parse($request->input('fecha_ini'))->format('Y-m-d');
        $fecha_req = Carbon::parse($request->input('fecha_req'))->format('Y-m-d');
        $id_estado = $request->input('id_estado');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        $id_supervisor = $request->input('supervisor');
        $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
        $rol_empleado_supervisor = Rol_empleado::where('nombre_rol_empleado', 'supervisor')->first();
        $estado = Estado::where('id_estado', $id_estado)->first();

        $responsabilidad = Responsabilidad::create([
            'id_empleado' => $id_responsable,
            'id_rol_empleado' => $rol_empleado->id_rol_empleado
        ]);

        $responsabilidad_supervisor = Responsabilidad::create([
            'id_empleado' => $id_supervisor,
            'id_rol_empleado' => $rol_empleado_supervisor->id_rol_empleado
        ]);

        $orden = Orden::create([
                    'nombre_orden' => $nombre_orden,
                    'duracion_estimada' => $duracion_estimada,
                    'fecha_inicio' => $fecha_ini,
                    'id_etapa' => $id_etapa
                ]);

        Responsabilidad_orden::create([
            'id_responsabilidad' => $responsabilidad->id_responsabilidad,
            'id_orden' => $orden->id_orden
        ]);

        Responsabilidad_orden::create([
            'id_responsabilidad' => $responsabilidad_supervisor->id_responsabilidad,
            'id_orden' => $orden->id_orden
        ]);

        

        $orden_trabajo = Orden_trabajo::create([
                            'id_tipo_orden_trabajo' => $tipo_orden_trabajo,
                            'id_orden' => $orden->id_orden
                        ]);

        $parte = Parte::create([
            'observaciones' => 'Generacion de orden de trabajo',
            'fecha' => $fecha_ini,
            'fecha_limite' => $fecha_req,
            'fecha_carga' => $fecha_carga,
            'horas' => '00:00',
            'id_orden' => $orden->id_orden,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad
        ]);

        Parte_trabajo::create([
            'id_estado' => $estado->id_estado,
            'id_parte' => $parte->id_parte
        ]);
    }

    public function crearOrdenMecanizado($request){
        $id_etapa = $request->input('num_etapa');
        $nombre_orden = $request->input('nom_orden');
        $revision = $request->input('revision');
        $cantidad = $request->input('cantidad');
        $duracion_estimada = $request->input('horas_estimadas') . ':' . $request->input('minutos_estimados');
        $id_responsable = $request->input('responsable');
        $fecha_ini = Carbon::parse($request->input('fecha_ini'))->format('Y-m-d');
        $fecha_req = Carbon::parse($request->input('fecha_req'))->format('Y-m-d');
        $id_estado_mec = $request->input('estado_mecanizado');
        $ruta_plano = $request->input('ruta_plano');
        $observaciones = $request->input('observaciones');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();

        $responsabilidad = Responsabilidad::create([
            'id_empleado' => $id_responsable,
            'id_rol_empleado' => $rol_empleado->id_rol_empleado
        ]);

        $orden_mecanizado = Orden_mecanizado::create([
            'revision' => $revision,
            'cantidad' => $cantidad,
            'fecha_inicio' => $fecha_ini,
            'fecha_requerida' => $fecha_req,
            'ruta_plano' =>  $ruta_plano,
            'observaciones' => $observaciones,
            'duracion_estimada' => $duracion_estimada,
            'id_etapa' => $id_etapa,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad
        ]);

        Parte_mecanizado::create([
            'observacion' => 'Generacion de orden mecanizado',
            'fecha' => $fecha_ini,
            'fecha_limite' => $fecha_req,
            'fecha_carga' => $fecha_carga,
            'horas' => '00:00',
            'id_estado_mecanizado' => $id_estado_mec,
            'id_orden_mecanizado' => $orden_mecanizado->id_orden_mecanizado,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad
        ]);

    }

    public function obtenerOrdenesDeUnaEtapa($id){
        $etapa = Etapa::find($id);
        $ordenes = array();

        foreach ($etapa->getOrden as $orden) {
            array_push($ordenes, (object)[
                'id_orden' => $orden->id_orden,
                'orden' => $orden->nombre_orden,
                'tipo' => 'Orden de trabajo',
                'numero_tipo' => 1
            ]);
        }

        // foreach ($etapa->getOrdenMecanizado as $orden_mecanizado) {
        //     array_push($ordenes, (object)[
        //         'id_orden' => $orden_mecanizado->id_orden_mecanizado,
        //         'orden' => $orden_mecanizado->observaciones,
        //         'tipo' => 'Orden de mecanizado',
        //         'numero_tipo' => 3
        //     ]);
        // }

        return $ordenes;
    }

    public function ObtenerOrdenTrabajo($id){
        $orden_trabajo = Orden::find($id);
        $orden_trabajo_arr = array();

        $supervisor = '';
        $responsable = '';
        foreach ($orden_trabajo->getResponsabilidaOrden as $resp_orden) {
            if(strcasecmp($resp_orden->getResponsabilidad->getRol->nombre_rol_empleado, 'supervisor') == 0){
                $supervisor = $resp_orden->getResponsabilidad->getEmpleado->nombre_empleado;
            }
            if(strcasecmp($resp_orden->getResponsabilidad->getRol->nombre_rol_empleado, 'responsable') == 0){
                $responsable = $resp_orden->getResponsabilidad->getEmpleado->nombre_empleado;
            }
        }

        array_push($orden_trabajo_arr, (object)[
            'id_orden' => $orden_trabajo->id_orden_trabajo,
            'orden' => $orden_trabajo->nombre_orden,
            'tipo' => $orden_trabajo->getOrdenTrabajo->getTipoOrdenTrabajo->nombre_tipo_orden_trabajo,
            'estado' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->getParteTrabajo->getEstado->nombre_estado,
            'responsable' => $responsable,
            'fecha_inicio' => Carbon::parse($orden_trabajo->getPartes->sortBy('id_parte')->first()->fecha)->format('d-m-Y'),
            'fecha_limite' => Carbon::parse($orden_trabajo->getPartes->sortByDesc('id_parte')->first()->fecha_limite)->format('d-m-Y'),
            'fecha_fin_real' => '+late',
            'duracion_estimada' => $orden_trabajo->duracion_estimada,
            'duracion_real' => '00:00',
            'fecha_ultimo_parte' => Carbon::parse($orden_trabajo->getPartes->sortByDesc('id_parte')->first()->fecha_carga)->format('d-m-Y'),
            'descripcion_ultimo_parte' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->observaciones,
            'supervisa' => $supervisor
            ]);
        return $orden_trabajo_arr;
    }

    public function ObtenerOrdenMecanizado($id){
        $orden_mecanizado = Orden_mecanizado::find($id);
        $orden_mecanizado_arr = array();

        array_push($orden_mecanizado_arr, (object)[
            'id_orden' => $orden_mecanizado->id_orden_mecanizado,
            // 'orden' => $orden_mecanizado->nombre_orden_trabajo,
            'revision' => $orden_mecanizado->revision,
            'cantidad' => $orden_mecanizado->cantidad,
            'ruta_plano' => $orden_mecanizado->ruta_plano,
            'observaciones' => $orden_mecanizado->observaciones,
            'estado_mecanizado' => $orden_mecanizado->getPartes->sortByDesc('id_parte_mecanizado')->first()->getEstadoMecanizado->nombre_estado_mecanizado,
            'responsable' => $orden_mecanizado->getResponsable->getEmpleado->nombre_empleado,
            'fecha_inicio' => Carbon::parse($orden_mecanizado->fecha_inicio)->format('d-m-Y'),
            'fecha_limite' => Carbon::parse($orden_mecanizado->getPartes->sortByDesc('id_parte_mecanizado')->first()->fecha_limite)->format('d-m-Y'),
            'fecha_fin_real' => '+late',
            'duracion_estimada' => $orden_mecanizado->duracion_estimada,
            'duracion_real' => '00:00',
            'fecha_ultimo_parte' => Carbon::parse($orden_mecanizado->getPartes->sortByDesc('id_parte_mecanizado')->first()->fecha_carga)->format('d-m-Y'),
            'descripcion_ultimo_parte' => $orden_mecanizado->getPartes->sortByDesc('id_parte_mecanizado')->first()->observacion,
            'supervisa' => $orden_mecanizado->getPartes->sortByDesc('id_parte_mecanizado')->first()->getResponsable->getEmpleado->nombre_empleado
            ]);
        return $orden_mecanizado_arr;
    }

    public function obtenerPartesDeTrabajo($id)
    {
        $orden = Orden::find($id);
        $partes_de_trabajo_arr = array();
        $supervisor = '';
        $responsable = '';
        foreach ($orden->getResponsabilidaOrden as $resp_orden) {
            if(strcasecmp($resp_orden->getResponsabilidad->getRol->nombre_rol_empleado, 'supervisor') == 0){
                $supervisor = $resp_orden->getResponsabilidad->getEmpleado->nombre_empleado;
            }
            if(strcasecmp($resp_orden->getResponsabilidad->getRol->nombre_rol_empleado, 'responsable') == 0){
                $responsable = $resp_orden->getResponsabilidad->getEmpleado->nombre_empleado;
            }
        }

        foreach ($orden->getPartes as $parte_trabajo) {
            array_push($partes_de_trabajo_arr, (object)[
                'fecha_carga' => Carbon::parse($parte_trabajo->fecha_carga)->format('d-m-Y H:i'),
                'estado' => $parte_trabajo->getParteTrabajo->getEstado->nombre_estado,
                'observaciones' => $parte_trabajo->observaciones,
                'fecha' => Carbon::parse($parte_trabajo->fecha)->format('d-m-Y'),
                'fecha_limite' => Carbon::parse($parte_trabajo->fecha_limite)->format('d-m-Y'),
                'horas' => Carbon::parse($parte_trabajo->horas)->format('H:i'),
                'supervisor' => $supervisor,
                'responsable' => $responsable
                //'responsable' => $orden->getResponsabilidaOrden->first()->getResponsable->getEmpleado->nombre_empleado,
                //'supervisor' => $parte_trabajo->getOrden->getResponsable->getEmpleado->nombre_empleado,
            ]);
        }
        return $partes_de_trabajo_arr;
    }

    public function obtenerTipoTrabajo(){
        return Tipo_orden_trabajo::orderBy('nombre_tipo_orden_trabajo')->get();
    }

    public function obtenerEmpleados(){
        return Empleado::orderBy('nombre_empleado')->get();
    }

    public function obtenerEstados(){
        return Estado::orderBy('nombre_estado')->get();
    }

    public function obtenerEstadosMecanizados(){
        return Estado_mecanizado::orderBy('nombre_estado_mecanizado')->get();
    }

    public function obtenerSupervisores(){
        return Empleado::orderBy('nombre_empleado')->get();
    }
}