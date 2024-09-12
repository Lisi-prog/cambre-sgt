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
use App\Models\Cambre\Servicio_info;
use App\Models\Cambre\Subtipo_servicio;
use App\Models\Cambre\Prioridad;
use App\Models\Cambre\Responsabilidad;
use App\Models\Cambre\Rol_empleado;
use App\Models\Cambre\Tipo_servicio;
use App\Models\Cambre\Estado;
use App\Models\Cambre\Estado_manufactura;
use App\Models\Cambre\Estado_mecanizado;
use App\Models\Cambre\Etapa;
use App\Models\Cambre\Actualizacion;
use App\Models\Cambre\Actualizacion_servicio;
use App\Models\Cambre\Actualizacion_etapa;
use App\Models\Cambre\Tipo_orden_trabajo;
use App\Models\Cambre\Cambio_de_prioridad;
use App\Models\Cambre\Prefijo_proyecto;
use App\Models\Cambre\Activo;
use App\Models\Cambre\Vw_servicio;
use App\Models\Cambre\Vw_etapa;
use App\Models\Cambre\Vw_gest_orden_trabajo;
use App\Models\Cambre\Vw_gest_orden_manufactura;
use App\Models\Cambre\Vw_gest_orden_mecanizado;
use App\Mail\Solicitud\SsiMailable;
use App\Mail\Solicitud\PmMailable;
use Illuminate\Support\Facades\Mail;

class ProyectoController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:VER-MENU-PROYECTO', ['only' => ['index']]);
        $this->middleware('permission:MODIFICAR-PRIORIDAD-PROYECTO', ['only' => ['actualizarPrioridadServicio']]); 
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
        
        
        $prefijos = Prefijo_proyecto::orderBy('nombre_prefijo_proyecto')->pluck('nombre_prefijo_proyecto', 'id_prefijo_proyecto');
        $empleados = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        $Tipos_servicios = Subtipo_servicio::orderBy('nombre_subtipo_servicio')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        $prioridades = [];
        $activos = Activo::whereNotNull('codigo_activo')->orderBy('codigo_activo')->pluck('codigo_activo', 'id_activo');
        $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        
        return view('Ingenieria.Servicios.Proyectos.index', compact('proyectos', 'empleados', 'Tipos_servicios', 'prioridadMax', 'prefijos', 'activos'));
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
        $prefijos = Prefijo_proyecto::orderBy('nombre_prefijo_proyecto')->pluck('nombre_prefijo_proyecto', 'id_prefijo_proyecto');
        $empleados = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        $Tipos_servicios = Subtipo_servicio::orderBy('nombre_subtipo_servicio')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        $activos = Activo::whereNotNull('codigo_activo')->orderBy('codigo_activo')->pluck('codigo_activo', 'id_activo');
        return view('Ingenieria.Servicios.Proyectos.index', compact('proyectos', 'empleados', 'Tipos_servicios', 'prioridadMax', 'tipo', 'prefijos', 'activos'));
    }

    public function indexPorPrefijo(Request $request, $opcion){
        // return $request->input('tipos');
        // return  Vw_servicio::servicio($request->input('cod_serv'))->get();
        $tipo_servicio = Tipo_servicio::where('nombre_tipo_servicio', 'proyecto')->first();
        $prefijos = Prefijo_proyecto::orderBy('nombre_prefijo_proyecto')->pluck('nombre_prefijo_proyecto', 'id_prefijo_proyecto');
        $empleados = $this->obtenerSupervisoresAdmin();
        $Tipos_servicios = Subtipo_servicio::orderByRaw('FIELD(id_subtipo_servicio, "1", "2", "4", "3", "5", "6")')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        // $Tipos_servicios = Subtipo_servicio::orderBy('nombre_subtipo_servicio')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        $activos = Activo::whereNotNull('codigo_activo')->orderBy('codigo_activo')->pluck('codigo_activo', 'id_activo');

        switch ($opcion) {
            case 1:
                $tipo = 'Servicios';
                $prefijos_busq = array();
                $proyectosFilter = Vw_servicio::orderBy('prioridad_servicio')->get();
                break;

            case 2:
                $tipo = 'Proyectos';
                $prefijos_busq = array('PROY', 'AU');
                $proyectosFilter = Vw_servicio::where('id_estado', '<', 9)->where(function ($query) use($prefijos_busq) {
                                                                                        foreach ($prefijos_busq as $prefijo){
                                                                                            $query->orwhere('codigo_servicio', 'like', '%'.$prefijo.'%');
                                                                                        }      
                                                                                    })->orderBy('prioridad_servicio')->get();
                break;

            case 3:
                $tipo = 'Servicio de ingenieria';
                $prefijos_busq = array('SSI');
                $proyectosFilter = Vw_servicio::where('id_subtipo_servicio', 5)->where('id_estado', '<', 9)->orWhere(function ($query) use($prefijos_busq) {
                                                                                                                foreach ($prefijos_busq as $prefijo){
                                                                                                                    $query->orwhere('codigo_servicio', 'like', '%'.$prefijo.'%');
                                                                                                                }      
                                                                                                            })->orderBy('prioridad_servicio')->get();
                break;

            case 4:
                $tipo = 'Mejora continua';
                $prefijos_busq = array('TMC');
                $proyectosFilter = Vw_servicio::where('id_estado', '<', 9)->where(function ($query) use($prefijos_busq) {
                                                                                        foreach ($prefijos_busq as $prefijo){
                                                                                            $query->orwhere('codigo_servicio', 'like', '%'.$prefijo.'%');
                                                                                        }      
                                                                                    })->orderBy('prioridad_servicio')->get();
                break;
        }

        $proyectos = Vw_servicio::servicio($request->input('cod_serv'))->tipo($request->input('tipos'))->prefijo($opcion, $prefijos_busq)->lider($request->input('lid'))->estado($request->input('estados'))->orderBy('prioridad_servicio')->get(['id_servicio', 'nombre_servicio', 'codigo_servicio', 'prioridad_servicio', 'nombre_subtipo_servicio', 'lider', 'nombre_estado', 'fecha_inicio', 'fecha_limite', 'total_ord', 'total_ord_completa', 'progreso']);
        
        
        //Para el filtro
            $supervisores = $this->obtenerSupervisoresFiltro();
            $codigos_servicio = $this->obtenerCodigoServicio();
            $subtipos_servicio = Subtipo_servicio::orderBy('nombre_subtipo_servicio')->get();
            $estados = Estado::orderBy('id_estado')->get();

            $flt_serv = $request->input('cod_serv');
            $flt_tip = $request->input('tipos');
            $flt_lid = $request->input('lid');
            $flt_est = $request->input('estados');
        //------------------
        
        return view('Ingenieria.Servicios.Proyectos.index', compact('proyectos', 'empleados', 'Tipos_servicios', 'prioridadMax', 'prefijos', 'activos', 'tipo', 'supervisores', 'codigos_servicio', 'subtipos_servicio', 'estados', 'proyectosFilter', 'flt_serv', 'flt_tip', 'flt_lid', 'flt_est', 'opcion'));
    }

    public function obtenerCodigoServicio(){
        return Servicio::orderBy('prioridad_servicio')->get(['id_servicio', 'codigo_servicio']);
    }

    public function obtenerSupervisoresFiltro(){
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
        
        $id_servicio = $this->guardarProyecto($request);

        if ($request->input('gesti')) {
            return redirect()->route('proyectos.gestionar', $id_servicio)->with('mensaje', 'El proyecto se ha creado con exito.');
        } else {
            return redirect()->back()->with('mensaje','El proyecto se ha creado con exito.');  
        }     
        //return redirect()->route('proyectos.index')->with('mensaje', 'El proyecto se ha creado con exito.');   
                        
    }

    public function guardarProyecto(Request $request){
        $activo = $request->input('id_activo');
        $codigo_proyecto = strtoupper($request->input('codigo_proyecto'));
        $nombre_proyecto = $request->input('nombre_proyecto');
        $tipo_proyecto = $request->input('id_tipo_proyecto');
        $lider = $request->input('lider');
        $fecha_ini = Carbon::parse($request->input('fecha_ini'))->format('Y-m-d');
        $fecha_req = Carbon::parse($request->input('fecha_req'))->format('Y-m-d');
        // $prioridad = $request->input('prioridad');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'lider')->first();

        $opt_est = $request->input('op_act_se_eta');
        if ($opt_est) {
            $estado = Estado::where('nombre_estado', 'En proceso')->first();
        } else {
            $estado = Estado::where('nombre_estado', 'espera')->first();
        }
        
        
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
            'prioridad_servicio' => $prioridadMax,
            'id_activo' => $activo
        ]);

        Servicio_info::create([
            'id_servicio' => $proyecto->id_servicio, 
            'tot_ord' => 0,
            'tot_ord_completa' => 0,
            'progreso' => 0
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
            'descripcion_etapa' => $nombre_proyecto,
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

        return $proyecto->id_servicio;
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
                return redirect()->back()->with('error', 'La prioridad del proyecto ya es la menor posible');
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

        return redirect()->back()->with('mensaje', 'La prioridad del proyecto actualizado exitosamente.');  
    }

    public function actualizarPrioridades($prioridadActual, $prioridadAnterior){
        DB::UPDATE('UPDATE servicio SET prioridad_servicio = prioridad_servicio - 1 WHERE prioridad_servicio <= ? AND prioridad_servicio > ?'  , [$prioridadActual, $prioridadAnterior]);
        DB::UPDATE('UPDATE servicio SET prioridad_servicio = prioridad_servicio + 1 WHERE prioridad_servicio >= ? AND prioridad_servicio < ?', [$prioridadActual, $prioridadAnterior]);
        
    }
    
    public function aceptar_solicitud(Request $request, $id, $opcion){

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

        $id_servicio = $this->guardarProyecto($request);


        $solicitud->update([
            'id_servicio' => $id_servicio
        ]);

        try {
            $nombre = $solicitud->getEmpleado->nombre_empleado;
            $codigo = $solicitud->id_solicitud;
            $email = strval($solicitud->getEmpleado->email_empleado);

            switch ($opcion) {
                case 1:
                    Mail::to($email)->send(new SsiMailable($nombre, $codigo, 2));
                    break;
                case 2:
                    Mail::to($email)->send(new PmMailable($nombre, $codigo, 2));
                    break;
                case 3:
                    //Mail::to($email)->send(new SsiMailable($nombre, $codigo, 2));
                    break;
                
            }
            
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect()->route('proyectos.gestionar', $id_servicio)->with('mensaje', 'El proyecto se ha creado con exito.');
        // return redirect()->back()->with('mensaje', 'El proyecto se ha creado con exito.'); 
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
    
        return redirect()->back()->with('mensaje', 'Proyecto editado exitosamente.');                        
    }
    
    public function destroy($id)
    {
                      
    }

    public function gestionar(Request $request, $id)
    {
        /* if ($request->input('tipo')) {
            $tipo = $request->input('tipo');
        }else{
            $tipo = 'Servicios';
        }

        if ($request->input('prefijo')) {
            $prefijo = $request->input('prefijo');
        }else{
            $prefijo = 1;
        } */

        if ($request->input('opcion')) {
            $opcion = $request->input('opcion');
        }else{
            $opcion = 1;
        }

        $Tipos_servicios = Subtipo_servicio::orderBy('nombre_subtipo_servicio')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        $proyecto = Servicio::find($id);
        $etapas_plk = $proyecto->getEtapas->sortBy('descripcion_etapa')->pluck('descripcion_etapa', 'id_etapa');
        $empleados = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        $supervisores_admin = $this->obtenerSupervisoresAdmin();
        $estados = Estado::orderBy('id_estado')->pluck('nombre_estado', 'id_estado');
        $tipo_orden = Tipo_orden_trabajo::orderBy('nombre_tipo_orden_trabajo')->pluck('nombre_tipo_orden_trabajo', 'id_tipo_orden_trabajo');
        $supervisores = $this->obtenerSupervisores();
        $costo_estimado = DB::select('SELECT TotalCostoEstimadoServicio(?) as costo_estimado;',[$id])[0]->costo_estimado;
        $costo_real = DB::select('SELECT TotalCostoRealServicio(?) as costo_real;',[$id])[0]->costo_real;
        $etapas = Vw_etapa::where('id_servicio', $id)->get();
        $ordenes_trabajo = Vw_gest_orden_trabajo::where('id_servicio', $id)->get();
        $ordenes_manufactura = Vw_gest_orden_manufactura::where('id_servicio', $id)->get();
        $ordenes_mecanizado = Vw_gest_orden_mecanizado::where('id_servicio', $id)->get();

        $flt_estados = Estado::orderBy('id_estado')->get();
        $flt_supervisores = $this->obtenerSupervisoresNoPluck();
        $flt_responsables = Empleado::orderBy('nombre_empleado')->get();
        $flt_estados_man = Estado_manufactura::orderBy('id_estado_manufactura')->get();
        $flt_estados_mec = Estado_mecanizado::orderBy('id_estado_mecanizado')->get();
 
        foreach ($proyecto->getEtapas->sortBy('descripcion_etapa') as $etapa) {
            foreach ($etapa->getOrden as $orden) {
                if ($orden->getOrdenDe->getTipoOrden() == 1) {
                    $eta_ord_trabajo[] = $orden->getEtapa->descripcion_etapa;
                }

                if ($orden->getOrdenDe->getTipoOrden() == 2) {
                    $eta_ord_manufactura[] = $orden->getEtapa->descripcion_etapa;
                }

                if ($orden->getOrdenDe->getTipoOrden() == 3) {
                    $eta_ord_mecanizado[] = $orden->getEtapa->descripcion_etapa;
                }
            }
        }

        try {
            $flt_eta_ord_tra = array_unique($eta_ord_trabajo);
        } catch (\Throwable $th) {
            $flt_eta_ord_tra = [];
        }
    
        try {
            $flt_eta_ord_man = array_unique($eta_ord_manufactura);
        } catch (\Throwable $th) {
            $flt_eta_ord_man = [];
        }
        
        try {
            $flt_eta_ord_mec = array_unique($eta_ord_mecanizado);
        } catch (\Throwable $th) {
            $flt_eta_ord_mec = [];
        }
        
        return view('Ingenieria.Servicios.Proyectos.gestionar',compact('proyecto', 'empleados', 'etapas_plk', 'tipo_orden', 'Tipos_servicios', 'estados', 'supervisores', 'supervisores_admin', 'flt_estados', 'flt_supervisores', 'flt_responsables', 'flt_estados_man', 'flt_estados_mec', 'flt_eta_ord_tra', 'flt_eta_ord_man', 'flt_eta_ord_mec', 'opcion', 'costo_estimado', 'costo_real', 'etapas', 'ordenes_trabajo', 'ordenes_manufactura', 'ordenes_mecanizado'));
    }

    public function costos($id)
    {
        $Tipos_servicios = Subtipo_servicio::orderBy('nombre_subtipo_servicio')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        $proyecto = Servicio::find($id);
        $etapas = $proyecto->getEtapas->pluck('descripcion_etapa', 'id_etapa');
        $empleados = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        $estados = Estado::orderBy('nombre_estado')->pluck('nombre_estado', 'id_estado');
        $tipo_orden = Tipo_orden_trabajo::orderBy('nombre_tipo_orden_trabajo')->pluck('nombre_tipo_orden_trabajo', 'id_tipo_orden_trabajo');
        $supervisores = $this->obtenerSupervisores();
        $supervisores_admin = $this->obtenerSupervisoresAdmin();
        $etapas_plk = $proyecto->getEtapas->sortBy('descripcion_etapa')->pluck('descripcion_etapa', 'id_etapa');
        return view('Ingenieria.Servicios.Proyectos.costos',compact('proyecto', 'empleados', 'etapas', 'tipo_orden', 'Tipos_servicios', 'estados', 'supervisores', 'supervisores_admin', 'etapas_plk'));
    }

    public function obtenerActualizacionesServicio($id){

        $actualizaciones_servicio = Actualizacion_servicio::where('id_servicio', $id)->get();
        $actualizacion_arr = array();

        foreach ($actualizaciones_servicio as $act_servicio) {

            array_push($actualizacion_arr, (object)[
                'codigo' => $act_servicio->getActualizacion->id_actualizacion,
                'fecha_carga' => Carbon::parse($act_servicio->getActualizacion->fecha_carga)->format('Y-m-d H:i'),
                'descripcion' => $act_servicio->getActualizacion->descripcion,
                'fecha_limite' => $act_servicio->getActualizacion->fecha_limite,
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
        $this->validate($request, [
            'm-ver-act-descripcion' => 'required',
            'm-ver-act-id_estado' => 'required',
            'm-ver-act-lider' => 'required',
            'm-ver-act-fecha_limite' => 'required'
        ]);

        $descripcion = $request->input('m-ver-act-descripcion');

        $id_estado = $request->input('m-ver-act-id_estado');

        $fecha_limite = $request->input('m-ver-act-fecha_limite');

        $lider = $request->input('m-ver-act-lider');

        $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();

        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');

        $act_eta_com = $request->input('eta_p');

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

        if ($act_eta_com) {
            $etapas_a_actualizar = Vw_etapa::where('id_servicio', $id)->whereNotIn('id_estado', [9, 10])->get();

            foreach ($etapas_a_actualizar as $etapa_act) {
                
                $responsabilidad_eta = Responsabilidad::create([
                    'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                    'id_rol_empleado' => $rol_empleado->id_rol_empleado
                ]);

                $actualizacion_eta = Actualizacion::create([
                                    'descripcion' => $descripcion,
                                    'fecha_limite' => $fecha_limite,
                                    'fecha_carga' => $fecha_carga,
                                    'id_estado' => $id_estado,
                                    'id_responsabilidad' => $responsabilidad_eta->id_responsabilidad
                                ]);

                Actualizacion_etapa::create([
                    'id_actualizacion' => $actualizacion_eta->id_actualizacion,
                    'id_etapa' => $etapa_act->id_etapa
                ]);
            }
        }
       

        $responsable_proyecto = $servicio->getResponsabilidad;
        if($responsable_proyecto->id_empleado != $lider){
            $responsable_proyecto->id_empleado = $lider;
            $responsable_proyecto->save();
        }
        

        if($servicio->getSolicitud){
            if ($id_estado == 9) {
                try {
                    $nombre = $servicio->getSolicitud->getEmpleado->nombre_empleado;
                    $codigo = $servicio->getSolicitud->id_solicitud;
                    $email = strval($servicio->getSolicitud->getEmpleado->email_empleado);

                    Mail::to($email)->send(new SsiMailable($nombre, $codigo, 5));    
                           
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }

        return redirect()->back()->with('mensaje', 'Actualizacion del proyecto creado exitosamente.');  
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

    public function obtenerSupervisoresNoPluck(){
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

    public function obtenerMayorCodigoServicioPrefijo($id){
        try {
            $bandera = 1;
            $prefijo = Prefijo_proyecto::find($id);
            $total_char = strlen($prefijo->nombre_prefijo_proyecto);
            $servicios = Servicio::where('codigo_servicio', 'like', $prefijo->nombre_prefijo_proyecto.'%')->orderBy('codigo_servicio', 'desc')->get('codigo_servicio');
            $codigo = $prefijo->nombre_prefijo_proyecto;
            foreach ($servicios as $servicio) {
                if(is_numeric(substr($servicio->codigo_servicio, $total_char)) && $bandera == 1){
                    $codigo = $servicio->codigo_servicio;
                    $bandera = 0;
                }
            }
            return ['codigo_servicio' => $codigo,
                    'servicios' => $servicios
                    ];
           // return $servicio_candidato = Servicio::where('codigo_servicio', 'like', '%'.$prefijo->nombre_prefijo_proyecto.'%')->orderBy('codigo_servicio', 'desc')->get('codigo_servicio')->first();
        } catch (\Throwable $th) {
            return '';
        }
    }

    public function obtenerUltimaActualizacion($id){
        $ultima_act = array();
        $servicio = Servicio::find($id);
        $act_servicio = $servicio->getUltimaActualizacion();
        array_push($ultima_act, (object)[
            'fecha_limite' => $act_servicio->getActualizacion->fecha_limite,
            'estado' => $act_servicio->getActualizacion->getEstado->id_estado,
            'lider' => $act_servicio->getActualizacion->getResponsable->getEmpleado->id_empleado
        ]);
        return $ultima_act;
    }
   

    public function obtener_progreso($id){
        $etapas_arr = [];
        $solicitud = Sol_solicitud::find($id);
        $servicio = Vw_servicio::find($solicitud->id_servicio);
        $etapas = Vw_etapa::where('id_servicio', $solicitud->id_servicio)->get();

        foreach ($etapas as $etapa) {
            array_push($etapas_arr, (object)[
                'descripcion_etapa' => $etapa->descripcion_etapa,
                'nombre_estado' => $etapa->nombre_estado,
                'fecha_inicio' => $etapa->fecha_inicio,
                'fecha_limite' => $etapa->fecha_limite,
                'progreso' => round($etapa->getProgreso())
            ]);
        }
        
        return [
            'id_serv' => $servicio->id_servicio,
            'cod_serv' => $servicio->codigo_servicio,
            'nom_serv' => $servicio->nombre_servicio,
            'lider' => $servicio->lider,
            'fec_ini' => $servicio->fecha_inicio,
            'fec_lim' => $servicio->fecha_limite ?? '-',
            'estado' => $servicio->nombre_estado,
            'progreso' => $servicio->progreso,
            'etapas' => $etapas_arr
        ];
    }
}