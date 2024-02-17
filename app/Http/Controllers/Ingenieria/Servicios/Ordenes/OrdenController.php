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
use App\Models\Cambre\Estado_manufactura;
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
use App\Models\Cambre\Orden_manufactura;
use App\Models\Cambre\Orden_mecanizado;
use App\Models\Cambre\Parte_manufactura;
use App\Models\Cambre\Parte_mecanizado;
use App\Models\Cambre\Tipo_relacion_gantt;
use App\Models\Cambre\Orden_gantt;

class OrdenController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        //  $this->middleware('permission:VER-PERMISO|CREAR-PERMISO|EDITAR-PERMISO|BORRAR-PERMISO', ['only' => ['index']]);
        //  $this->middleware('permission:CREAR-PERMISO', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-PERMISO', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-PERMISO', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:BORRAR-ORDEN|SUPERVISOR', ['only' => ['destroy', 'eliminarOrden']]);

    }
    
    public function index(Request $request)
    {        
        if (Auth::user()->hasRole('SUPERVISOR')) {
            $ordenes_trabajo = Orden::orderBy('id_orden')->get();
            $supervisores = User::role('SUPERVISOR')->get();
            $responsables = Empleado::orderBy('nombre_empleado')->get();
            $estados = $this->listarTodosLosEstados();
            return view('Ingenieria.Servicios.Ordenes.index', compact('ordenes_trabajo', 'supervisores', 'responsables', 'estados'));
        } else {

            try {
                $listaOrden = $this->listaOrdenEmp();
            } catch (\Throwable $th) {
                $listaOrden = [];
            }
            
            $ordenes_trabajo = Orden::whereIn('id_orden', $listaOrden)->orderBy('id_orden')->get();
            return view('Ingenieria.Servicios.Ordenes.index-emp', compact('ordenes_trabajo'));
        }   
    }

    public function listarTodosLosEstados(){
        $estados_arr = array();

        //$estados = Estado::get();

        foreach (Estado::get() as $estado) {
            array_push($estados_arr, (object)[
                'nombre' => $estado->nombre_estado
            ]);
        }

        foreach (Estado_mecanizado::get() as $estado) {
            array_push($estados_arr, (object)[
                'nombre' => $estado->nombre_estado_mecanizado
            ]);
        }

        foreach (Estado_manufactura::get() as $estado) {
            array_push($estados_arr, (object)[
                'nombre' => $estado->nombre_estado_manufactura
            ]);
        }

        return $estados_arr;
    }
    
    public function listarTodosLosEstadosDe($opcion){
        $estados_arr = array();

        switch ($opcion) {
            case 1:
                foreach (Estado::get() as $estado) {
                    array_push($estados_arr, (object)[
                        'nombre' => $estado->nombre_estado
                    ]);
                }
                break; 
            case 2:
                foreach (Estado_manufactura::get() as $estado) {
                    array_push($estados_arr, (object)[
                        'nombre' => $estado->nombre_estado_manufactura
                    ]);
                }
                break;
            case 3:
                foreach (Estado_mecanizado::get() as $estado) {
                    array_push($estados_arr, (object)[
                        'nombre' => $estado->nombre_estado_mecanizado
                    ]);
                }
                break;
            default:
                # code...
                break;
        }
        return $estados_arr;
    }

    public function listaOrdenEmp(){
        $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first()->id_rol_empleado;
        $responsabilidades = Responsabilidad::where('id_rol_empleado', $rol_empleado)->where('id_empleado', Auth::user()->getEmpleado->id_empleado)->get();

        foreach ($responsabilidades as $responsabilidad) {
            $id_resp[] = $responsabilidad->id_responsabilidad;
        }

        $responsabilidades_orden = Responsabilidad_orden::whereIn('id_responsabilidad', $id_resp)->get();

        foreach ($responsabilidades_orden as $responsabilidad_orden) {
            $id_ordenes[] = $responsabilidad_orden->id_orden;
        }

        return $id_ordenes;
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
                    'horas_estimadas.required' => 'Faltan las horas estimadas',
                    'supervisor.required' => 'Seleccione un supervisor'
                ]);

                $this->crearOrdenTrabajo($request);
                
                return redirect()->route('proyectos.gestionar', $servicio)->with('mensaje', 'La orden de trabajo y el parte de trabajo se ha creado con exito.'); 
                break;
            case 2:
                # Crear orden de manufactura
                $this->validate($request, [
                    'num_etapa' => 'required',
                    'nom_orden' => 'required',
                    'horas_estimadas' => 'required',
                    'minutos_estimados' => 'required',
                    'responsable' => 'required',
                    'supervisor' => 'required',
                    'revision' => 'required',
                    'cantidad' => 'required',
                    'fecha_ini' => 'required',
                    'estado_manufactura' => 'required',
                    'fecha_req' => 'required',
                    'ruta_plano' => 'required'
                ], [
                    'num_etapa.required' => 'Seleccione una etapa.',
                    'nom_orden.required' => 'Falta el nombre de la orden.',
                    'horas_estimadas.required' => 'Faltan las horas estimadas.',
                    'minutos_estimados.required' => 'Faltan los minutos estimados.',
                    'responsable.required' => 'Seleccione un responsable',
                    'supervisor.required' => 'Seleccione un supervisor',
                    'revision.required' => 'Falta el numero de revision',
                    'cantidad.required' => 'Falta la cantidad',
                    'fecha_ini.required' => 'Seleccione una fecha de inicio.',
                    'estado_manufactura.required' => 'Seleccione una etapa.',
                    'fecha_req.required' => 'Seleccione una fecha limite.',
                    'ruta_plano.required' => 'Falta la ruta del plano.'
                ]);

                $this->crearOrdenManufactura($request);

                return redirect()->route('proyectos.gestionar', $servicio)->with('mensaje', 'La orden de manufactura y el parte de manufactura se ha creado con exito.');
                break;
            case 3:
                # Crear orden de mecanizado
                $this->validate($request, [
                    'num_etapa' => 'required',
                    'nom_orden' => 'required',
                    'horas_estimadas' => 'required',
                    'minutos_estimados' => 'required',
                    'responsable' => 'required',
                    'supervisor' => 'required',
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
                    'supervisor.required' => 'Seleccione un supervisor',
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

        //Calculamos los costos despues de asignar responsabilidades
        $orden->costo_estimado = $orden->getCostoEstimado();
        $orden->save();

        $orden_trabajo = Orden_trabajo::create([
                            'id_tipo_orden_trabajo' => $tipo_orden_trabajo,
                            'id_orden' => $orden->id_orden
                        ]);
        //responsabilidad de la creacion del parte:
        $rol_empleado_parte = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
        $responsabilidad_parte = Responsabilidad::create([
            'id_empleado' => Auth::user()->getEmpleado->id_empleado,
            'id_rol_empleado' => $rol_empleado_parte->id_rol_empleado
        ]);
        
        $parte = Parte::create([
            'observaciones' => 'Generacion de orden de trabajo',
            'fecha' => $fecha_ini,
            'fecha_limite' => $fecha_req,
            'fecha_carga' => $fecha_carga,
            'horas' => '00:00',
            'id_orden' => $orden->id_orden,
            'id_responsabilidad' => $responsabilidad_parte->id_responsabilidad
        ]);

        Parte_trabajo::create([
            'id_estado' => $estado->id_estado,
            'id_parte' => $parte->id_parte
        ]);
    }

    public function crearOrdenManufactura($request){
        $id_etapa = $request->input('num_etapa');
        $nombre_orden = $request->input('nom_orden');
        $revision = $request->input('revision');
        $cantidad = $request->input('cantidad');
        $duracion_estimada = $request->input('horas_estimadas') . ':' . $request->input('minutos_estimados');
        $id_responsable = $request->input('responsable');
        $fecha_ini = Carbon::parse($request->input('fecha_ini'))->format('Y-m-d');
        $fecha_req = Carbon::parse($request->input('fecha_req'))->format('Y-m-d');
        $id_estado_man = $request->input('estado_manufactura');
        $ruta_plano = $request->input('ruta_plano');
        //$observaciones = $request->input('observaciones');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
        $rol_empleado_supervisor = Rol_empleado::where('nombre_rol_empleado', 'supervisor')->first();
        $id_supervisor = $request->input('supervisor');

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

        //Calculamos los costos despues de asignar responsabilidades
        $orden->costo_estimado = $orden->getCostoEstimado();
        $orden->save();

        Orden_manufactura::create([
            'revision' => $revision,
            'cantidad' => $cantidad,
            'ruta_plano' => $ruta_plano,
            'id_orden' => $orden->id_orden
        ]);

        $parte = Parte::create([
            'observaciones' => 'Generacion de orden de manufactura',
            'fecha' => $fecha_ini,
            'fecha_limite' => $fecha_req,
            'fecha_carga' => $fecha_carga,
            'horas' => '00:00',
            'id_orden' => $orden->id_orden,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad
        ]);

        Parte_manufactura::create([
            'id_estado_manufactura' => $id_estado_man,
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
        //$observaciones = $request->input('observaciones');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();
        $rol_empleado_supervisor = Rol_empleado::where('nombre_rol_empleado', 'supervisor')->first();
        $id_supervisor = $request->input('supervisor');
        $id_orden_manufactura = $request->input('id_orden_manuf');

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

        //Calculamos los costos despues de asignar responsabilidades
        $orden->costo_estimado = $orden->getCostoEstimado();
        $orden->save();

        Orden_mecanizado::create([
            'revision' => $revision,
            'cantidad' => $cantidad,
            'ruta_pieza' => $ruta_plano,
            'id_orden' => $orden->id_orden,
            'id_orden_manufactura' => $id_orden_manufactura
        ]);

        $parte = Parte::create([
            'observaciones' => 'Generacion de orden de mecanizado',
            'fecha' => $fecha_ini,
            'fecha_limite' => $fecha_req,
            'fecha_carga' => $fecha_carga,
            'horas' => '00:00',
            'id_orden' => $orden->id_orden,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad
        ]);

        Parte_mecanizado::create([
            'id_estado_mecanizado' => $id_estado_mec,
            'id_parte' => $parte->id_parte
        ]);

    }

    public function validarOrdenMecanizado(Request $request){
        $id_orden_manufactura = $request->input('id_orden_manuf');
        $id_orden = $request->input('id_orden');
        $this->validate($request, [
            'num_etapa' => 'required',
            'nom_orden' => 'required',
            'horas_estimadas' => 'required',
            'minutos_estimados' => 'required',
            'responsable' => 'required',
            'supervisor' => 'required',
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

        return redirect()->route('ordenes.manufacturamecanizado', $id_orden)->with('mensaje', 'La orden de mecanizado se ha creado con exito.');
    }

    public function obtenerOrdenesDeUnaEtapa($id){
        $etapa = Etapa::find($id);
        $ordenes = array();

        foreach ($etapa->getOrden as $orden) {
            array_push($ordenes, (object)[
                'etapa' => $etapa->descripcion_etapa,
                'id_orden' => $orden->id_orden,
                'orden' => $orden->nombre_orden,
                'tipo' => 'Orden de '.$orden->getOrdenDe->getNombreTipoOrden(),
                'estado' => $orden->getEstado(),
                'responsable' => $orden->getNombreResponsable(),
                'numero_tipo' => $orden->getOrdenDe->getTipoOrden()
            ]);
        }
        return $ordenes;
    }

    public function obtenerOrdenesDeUnaEtapaTipo($id, $tipo){
        $etapa = Etapa::find($id);
        $ordenes = array();

        foreach ($etapa->getOrden as $orden) {
            if ($orden->getOrdenDe->getTipoOrden() == $tipo) {
                array_push($ordenes, (object)[
                    'etapa' => $etapa->descripcion_etapa,
                    'id_orden' => $orden->id_orden,
                    'orden' => $orden->nombre_orden,
                    'tipo' => 'Orden de '.$orden->getOrdenDe->getNombreTipoOrden(),
                    'estado' => $orden->getEstado(),
                    'responsable' => $orden->getNombreResponsable(),
                    'supervisor' => $orden->getSupervisor(),
                    'fecha_limite' => Carbon::parse($orden->getPartes->sortByDesc('id_orden')->first()->fecha_limite ?? '')->format('d-m-Y'),
                    'fecha_finalizacion' => $orden->getFechaFinalizacion(),
                    'numero_tipo' => $orden->getOrdenDe->getTipoOrden()
                ]);
            }   
        }
        return $ordenes;
    }
    
    public function ObtenerOrdenTrabajo($id){
        $orden_trabajo = Orden::find($id);
        $orden_trabajo_arr = array();
        
        $supervisor = '';
        $responsable = '';
        $id_supervisor = '';
        $id_responsable = '';
        foreach ($orden_trabajo->getResponsabilidaOrden as $resp_orden) {
            if(strcasecmp($resp_orden->getResponsabilidad->getRol->nombre_rol_empleado, 'supervisor') == 0){
                $supervisor = $resp_orden->getResponsabilidad->getEmpleado->nombre_empleado;
                $id_supervisor = $resp_orden->getResponsabilidad->getEmpleado->id_empleado;
            }
            if(strcasecmp($resp_orden->getResponsabilidad->getRol->nombre_rol_empleado, 'responsable') == 0){
                $responsable = $resp_orden->getResponsabilidad->getEmpleado->nombre_empleado;
                $id_responsable = $resp_orden->getResponsabilidad->getEmpleado->id_empleado;
            }
        }

        switch ($orden_trabajo->getOrdenDe->getTipoOrden()) {
            case 1:
                array_push($orden_trabajo_arr, (object)[
                    'id_orden' => $orden_trabajo->id_orden,
                    'orden' => $orden_trabajo->nombre_orden,
                    'id_tipo' => $orden_trabajo->getOrdenDe->getTipoOrdenTrabajo->id_tipo_orden_trabajo,
                    'tipo' => $orden_trabajo->getOrdenDe->getTipoOrdenTrabajo->nombre_tipo_orden_trabajo,
                    'id_estado' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->getParteDe->getEstado->id_estado,
                    'estado' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->getParteDe->getEstado->nombre_estado,
                    'id_responsable' => $id_responsable,
                    'responsable' => $responsable,
                    'fecha_inicio' => $orden_trabajo->fecha_inicio,
                    'fecha_limite' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->fecha_limite,
                    'fecha_fin_real' => $orden_trabajo->getFechaFinalizacion(),
                    'duracion_estimada' => substr($orden_trabajo->duracion_estimada, 0, strlen($orden_trabajo->duracion_estimada)-3),
                    'duracion_real' => $orden_trabajo->getCalculoHorasReales(),
                    'costo_estimado' => $orden_trabajo->getCostoEstimado(),
                    'costo_real' => $orden_trabajo->getCostoReal(),
                    'fecha_ultimo_parte' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->fecha_carga,
                    'descripcion_ultimo_parte' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->observaciones,
                    'id_supervisor' => $id_supervisor,
                    'supervisa' => $supervisor
                    ]);
                break;
            case 2:
                array_push($orden_trabajo_arr, (object)[
                    'id_orden' => $orden_trabajo->id_orden,
                    'orden' => $orden_trabajo->nombre_orden,
                    'revision' => $orden_trabajo->getOrdenDe->revision,
                    'cantidad' => $orden_trabajo->getOrdenDe->cantidad,
                    'ruta_plano' => $orden_trabajo->getOrdenDe->ruta_plano,
                    'id_estado' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->getParteDe->getEstadoManufactura->id_estado_manufactura,
                    'estado' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->getParteDe->getEstadoManufactura->nombre_estado_manufactura,
                    'id_responsable' => $id_responsable,
                    'responsable' => $responsable,
                    'fecha_inicio' => $orden_trabajo->fecha_inicio,
                    'fecha_limite' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->fecha_limite,
                    'fecha_fin_real' => $orden_trabajo->getFechaFinalizacion(),
                    'duracion_estimada' => substr($orden_trabajo->duracion_estimada, 0, strlen($orden_trabajo->duracion_estimada)-3),
                    'duracion_real' => $orden_trabajo->getCalculoHorasReales(),
                    'costo_estimado' => $orden_trabajo->getCostoEstimado(),
                    'costo_real' => $orden_trabajo->getCostoReal(),
                    'fecha_ultimo_parte' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->fecha_carga,
                    'descripcion_ultimo_parte' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->observaciones,
                    'id_supervisor' => $id_supervisor,
                    'supervisa' => $supervisor
                    ]);
                break;
            case 3:
                array_push($orden_trabajo_arr, (object)[
                    'id_orden' => $orden_trabajo->id_orden,
                    'orden' => $orden_trabajo->nombre_orden,
                    'revision' => $orden_trabajo->getOrdenDe->revision,
                    'cantidad' => $orden_trabajo->getOrdenDe->cantidad,
                    'ruta_plano' => $orden_trabajo->getOrdenDe->ruta_pieza,
                    'id_estado' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->getParteDe->getEstadoMecanizado->id_estado_mecanizado,
                    'estado' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->getParteDe->getEstadoMecanizado->nombre_estado_mecanizado,
                    'id_responsable' => $id_responsable,
                    'responsable' => $responsable,
                    'fecha_inicio' => $orden_trabajo->fecha_inicio,
                    'fecha_limite' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->fecha_limite,
                    'fecha_fin_real' => $orden_trabajo->getFechaFinalizacion(),
                    'duracion_estimada' => substr($orden_trabajo->duracion_estimada, 0, strlen($orden_trabajo->duracion_estimada)-3),
                    'duracion_real' => $orden_trabajo->getCalculoHorasReales(),
                    'costo_estimado' => $orden_trabajo->getCostoEstimado(),
                    'costo_real' => $orden_trabajo->getCostoReal(),
                    'fecha_ultimo_parte' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->fecha_carga,
                    'descripcion_ultimo_parte' => $orden_trabajo->getPartes->sortByDesc('id_parte')->first()->observaciones,
                    'id_supervisor' => $id_supervisor,
                    'supervisa' => $supervisor
                    ]);
                break;
            default:
                # code...
                break;
        }

        
        return $orden_trabajo_arr;
    }

    public function ObtenerOrdenMecanizado($id){
        $orden_mecanizado = Orden::find($id);
        $orden_mecanizado_arr = array();

        array_push($orden_mecanizado_arr, (object)[
            'id_orden' => $orden_mecanizado->getOrdenDe->id_orden_mecanizado,
            'orden' => $orden_mecanizado->nombre_orden,
            'revision' => $orden_mecanizado->getOrdenDe->revision,
            'cantidad' => $orden_mecanizado->getOrdenDe->cantidad,
            'ruta_plano' => $orden_mecanizado->getOrdenDe->ruta_pieza,
            //'observaciones' => $orden_mecanizado->observaciones,
            'estado_mecanizado' => $orden_mecanizado->getEstado(),
            'responsable' => $orden_mecanizado->getNombreResponsable(),
            'fecha_inicio' => Carbon::parse($orden_mecanizado->fecha_inicio)->format('d-m-Y'),
            'fecha_limite' => Carbon::parse($orden_mecanizado->getPartes->sortByDesc('id_parte_mecanizado')->first()->fecha_limite)->format('d-m-Y'),
            'fecha_fin_real' => $orden_mecanizado->getFechaFinalizacion(),
            'duracion_estimada' => $orden_mecanizado->duracion_estimada,
            'duracion_real' => '00:00',
            //'fecha_ultimo_parte' => Carbon::parse($orden_mecanizado->getPartes->sortByDesc('id_parte_mecanizado')->first()->fecha_carga)->format('d-m-Y'),
            // 'descripcion_ultimo_parte' => $orden_mecanizado->getPartes->sortByDesc('id_parte_mecanizado')->first()->observacion,
            // 'supervisa' => $orden_mecanizado->getPartes->sortByDesc('id_parte_mecanizado')->first()->getResponsable->getEmpleado->nombre_empleado
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
                'estado' => $parte_trabajo->getParteDe->getNombreEstado(),
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

    public function obtenerEstadosManufacturas(){
        return Estado_manufactura::orderBy('nombre_estado_manufactura')->get();
    }

    public function obtenerEstadosMecanizados(){
        return Estado_mecanizado::orderBy('nombre_estado_mecanizado')->get();
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
        

        return Empleado::whereIn('id_empleado', $id_supervisores)->orderBy('nombre_empleado')->get();
    }

    public function verMecanizados($id){
        $orden_manufactura = Orden::find($id);
        $orden_manufactura = $orden_manufactura->getOrdenDe;
        $empleados = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        return view('Ingenieria.Servicios.Ordenes.crear-mecanizado-manufactura', compact('orden_manufactura', 'empleados'));
    }

    public function relacionarOrdenes(){
        $ordenes = Orden::orderBy('fecha_inicio', 'asc')->get();
        $ordenes_relacionadas = Orden_gantt::orderBy('id_orden_gantt', 'asc')->get();
        $relaciones = Tipo_relacion_gantt::orderBy('id_tipo_relacion_gantt')->pluck('nombre_relacion_gantt', 'id_tipo_relacion_gantt');
        $supervisores = $this->obtenerEmpleados();
        $responsables = $this->obtenerEmpleados();
        $estados = $this->listarTodosLosEstados();
        return view('Ingenieria.Servicios.Ordenes.relacionar-ordenes', compact('ordenes', 'relaciones', 'supervisores', 'responsables', 'estados'));
    }

    public function guardarRelacionesOrdenes(Request $request){

        for ($i=0; $i < count($request->id_orden_hija); $i++) { 
            if(!empty($request->id_orden_hija[$i]) && !empty($request->relacion[$i])){
                Orden_gantt::create([
                    'id_tipo_relacion_gantt' => $request->relacion[$i],
                    'id_orden_anterior' => $request->id_orden[$i],
                    'id_orden_siguiente' => $request->id_orden_hija[$i]
                ]);
            }
        }
        return $this->relacionarOrdenes();
    }

    // VISTAS DE ORDENES
    public function obtenerOrdenes($tipo_orden){
        $id_empleado = Auth::user()->getEmpleado->id_empleado;
        $supervisores = $this->obtenerSupervisores();
        $responsables = $this->obtenerEmpleados();
        //$estados = $this->listarTodosLosEstados();
        $tipo = '';
        $array_responsabilidades_ordenes = array();
        $array_ordenes = array();
        $ordenes = array();

        if (Auth::user()->hasRole('SUPERVISOR')) {
            //SI ES SUPERVISOR TRAIGO TODAS LAS ORDENES
            $array_ordenes = Orden::orderBy('id_orden', 'asc')->get();
        }else{
            //SI NO ES SUPERVISOR TRAIGO SOLO LAS DEL EMPLEADO LOGUEADO
            $responsabilidades = Responsabilidad::where('id_empleado', $id_empleado)->get();
            foreach ($responsabilidades as $responsabilidad) {
                is_null($responsabilidad->getResponsabilidadOrden) ? '' : array_push($array_responsabilidades_ordenes, $responsabilidad->getResponsabilidadOrden);
            }
            foreach ($array_responsabilidades_ordenes as $responsabilidad_orden) {
                array_push($array_ordenes, $responsabilidad_orden->getOrden);
            }
        }
        
        //FILTRAMOS LAS ORDENES POR TIP0
        switch ($tipo_orden) {           
            case 1:
                //ORDEN DE TRABAJO
                foreach ($array_ordenes as $orden) {
                    if (count(Orden_trabajo::where('id_orden', $orden->id_orden)->get()) == 1) {
                        array_push($ordenes, $orden);
                    }
                }
                $tipo = 'Trabajo';
                $estados = $this->listarTodosLosEstadosDe(1);
                break;
            case 2:
                //ORDEN DE MANUFACTURA
                foreach ($array_ordenes as $orden) {
                    if (count(Orden_manufactura::where('id_orden', $orden->id_orden)->get()) == 1) {
                        array_push($ordenes, $orden); ;
                    }
                }
                $tipo = 'Manufactura';
                $estados = $this->listarTodosLosEstadosDe(2);
                break;
            case 3:
                //ORDEN DE MECANIZADO
                foreach ($array_ordenes as $orden) {
                    if (count(Orden_mecanizado::where('id_orden', $orden->id_orden)->get()) == 1) {
                        array_push($ordenes, $orden); ;
                    }
                }
                $tipo = 'Mecanizado';
                $estados = $this->listarTodosLosEstadosDe(3);
                break;
            case 4:
                //ORDEN DE MANTENIMIENTO
                foreach ($array_ordenes as $orden) {
                    if (count(Orden_mantenimiento::where('id_orden', $orden->id_orden)->get()) == 1) {
                        array_push($ordenes, $orden); ;
                    }
                }
                $tipo = 'Mantenimiento';
                $estados = $this->listarTodosLosEstadosDe(1);
                break;
            default:
                # code...
                break;
        }
        
        return view('Ingenieria.Servicios.Ordenes.ordenes', compact('ordenes', 'supervisores', 'responsables', 'estados', 'tipo', 'tipo_orden'));
    }

    public function editarOrden(Request $request){
        $orden = Orden::find($request->input('id_orden_edit'));
        $tipo_orden = $orden->getOrdenDe->getTipoOrden();
        switch ($tipo_orden) {
            case 1:
                $this->validate($request, [
                    'nom_orden_edit' => 'required',
                    'supervisor_edit' => 'required',
                    'responsable_edit' => 'required',
                    'fecha_ini_edit' => 'required',
                    'fecha_req_edit' => 'required',
                    'id_estado_edit' => 'required',
                    'tipo_orden_trabajo_edit' => 'required',
                    'horas_estimadas_edit' => 'required',
                    'minutos_estimados_edit' => 'required'
                ]);
                break;
            case 2:
                $this->validate($request, [
                    'nom_orden_edit' => 'required',
                    'supervisor_edit' => 'required',
                    'responsable_edit' => 'required',
                    'fecha_ini_edit' => 'required',
                    'fecha_req_edit' => 'required',
                    'estado_man_edit' => 'required',
                    'horas_estimadas_edit' => 'required',
                    'minutos_estimados_edit' => 'required',
                    'ruta_plano_edit' => 'required'
                ]);
                break;
            case 3:
                $this->validate($request, [
                    'nom_orden_edit' => 'required',
                    'supervisor_edit' => 'required',
                    'responsable_edit' => 'required',
                    'fecha_ini_edit' => 'required',
                    'fecha_req_edit' => 'required',
                    'estado_mecanizado_edit' => 'required',
                    'horas_estimadas_edit' => 'required',
                    'minutos_estimados_edit' => 'required',
                    'ruta_plano_edit' => 'required'
                ]);
                break;
            default:
                # code...
                break;
        }
        

        
        $orden->update([
            'nombre_orden' => $request->input('nom_orden_edit'),
            'fecha_inicio' => $request->input('fecha_ini_edit'),
            'duracion_estimada' => $request->input('horas_estimadas_edit') . ':' . $request->input('minutos_estimados_edit')
        ]);

        $responsabilidades_orden = $orden->getResponsabilidaOrden;
        $responsabilidad_res = '';
        $responsabilidad_sup = '';
        foreach ($responsabilidades_orden as $resp_ord) {
           $rol = $resp_ord->getResponsabilidad->getRol->nombre_rol_empleado;
           switch ($rol) {
            case 'Responsable':
                $responsabilidad_res = $resp_ord->getResponsabilidad;
                if($responsabilidad_res->getEmpleado->id_empleado != $request->input('responsable_edit')){
                    $responsabilidad_res->id_empleado = $request->input('responsable_edit');
                    $responsabilidad_res->save();
                }
                break;
            case 'Supervisor':
                $responsabilidad_sup = $resp_ord->getResponsabilidad;
                if($responsabilidad_sup->getEmpleado->id_empleado != $request->input('supervisor_edit')){
                    $responsabilidad_sup->id_empleado = $request->input('supervisor_edit');
                    $responsabilidad_sup->save();
                }
                break;
            default:
                # code...
                break;
           }
        }
        $fecha = Carbon::now()->format('Y-m-d');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');

        $responsabilidad = Responsabilidad::create([
            'id_empleado' => Auth::user()->getEmpleado->id_empleado,
            'id_rol_empleado' => 1
        ]);

        $parte = Parte::create([
            'observaciones' => 'Edicion de orden',
            'fecha' => Carbon::now()->format('Y-m-d'),
            'fecha_limite' => $request->input('fecha_req_edit'),
            'fecha_carga' => Carbon::now()->format('Y-m-d H:i:s'),
            'horas' => '00:00',
            'id_orden' => $orden->id_orden,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad
        ]);

        switch ($tipo_orden) {
            case 1:
                Parte_trabajo::create([
                    'id_estado' => $request->input('id_estado_edit'),
                    'id_parte' => $parte->id_parte
                ]);
                break;
            case 2:
                $orden_manufactura = $orden->getOrdenDe;
                $orden_manufactura->revision = $request->input('revision_edit');
                $orden_manufactura->cantidad = $request->input('cantidad_edit');
                $orden_manufactura->ruta_plano = $request->input('ruta_plano_edit');
                $orden_manufactura->save();
                Parte_manufactura::create([
                    'id_estado_manufactura' => $request->input('estado_man_edit'),
                    'id_parte' => $parte->id_parte
                ]);
                break;
            case 3:
                $orden_mecanizado = $orden->getOrdenDe;
                $orden_mecanizado->revision = $request->input('revision_edit');
                $orden_mecanizado->cantidad = $request->input('cantidad_edit');
                $orden_mecanizado->ruta_pieza = $request->input('ruta_plano_edit');
                $orden_mecanizado->save();
                Parte_mecanizado::create([
                    'id_estado_mecanizado' => $request->input('estado_mecanizado_edit'),
                    'id_parte' => $parte->id_parte
                ]);
                break;
            default:
                # code...
                break;
        }
        return redirect()->route('ordenes.tipo', $tipo_orden)->with('mensaje', 'La orden ha sido editada con exito.');
    }

    public function eliminarOrden($id_orden){
            $orden = Orden::find($id_orden);
            $responsabilidades_orden = $orden->getResponsabilidaOrden;
            $orden_de_x = $orden->getOrdenDe;
            $partes = $orden->getPartes;
            //Borramos partes ligadas a la orden
            foreach ($partes as $parte) {
            $parte->getParteDe()->delete();
            $parte->delete();
            }
            //Borramos la responsabilidad ligada a la orden
            foreach ($responsabilidades_orden as $responsabilidad_orden) {
                $responsabilidad = $responsabilidad_orden->getResponsabilidad;
                $responsabilidad_orden->delete();
                $responsabilidad->delete();
            }
            //Borramos la orden
            $orden_de_x->delete();
            $orden->delete();
            return redirect()->back()->with('mensaje','Se elimino la orden con exito.');
    }
}