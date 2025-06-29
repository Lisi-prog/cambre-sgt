<?php

namespace App\Http\Controllers\Ingenieria\Servicios\Partes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
//agregamos 
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Models\Cambre\Orden;
use App\Models\Cambre\Estado;
use App\Models\Cambre\Estado_manufactura;
use App\Models\Cambre\Estado_mecanizado;
use App\Models\Cambre\Parte;
use App\Models\Cambre\Parte_trabajo;
use App\Models\Cambre\Parte_mecanizado;
use App\Models\Cambre\Parte_manufactura;
use App\Models\Cambre\Responsabilidad;
use App\Models\Cambre\Rol_empleado;
use App\Models\Cambre\Maquinaria;
use App\Models\Cambre\Parte_mecanizado_x_maquinaria;
use App\Models\Cambre\Empleado;
use App\Models\Cambre\Log_parte;
use App\Models\Cambre\Servicio;
use App\Models\Cambre\Vw_parte_trabajo;
use App\Models\Cambre\Vw_parte_manufactura;
use App\Models\Cambre\Vw_parte_mecanizado;
use App\Models\Cambre\Vw_orden_trabajo;
use App\Models\Cambre\Vw_orden_manufactura;
use App\Models\Cambre\Vw_orden_mecanizado;
use App\Mail\Solicitud\ParteMailable;
use App\Models\Cambre\Not_notificacion_cuerpo;
use App\Models\Cambre\Not_notificacion;

class ParteController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        //  $this->middleware('permission:VER-ROL|CREAR-ROL|EDITAR-ROL|BORRAR-ROL', ['only' => ['index','buscarrol']]);
        //  $this->middleware('permission:CREAR-ROL', ['only' => ['create','store','creargrupo','guardargrupo','storegrupoNuevo']]);
        //  $this->middleware('permission:EDITAR-ROL', ['only' => ['edit','update','storegrupoEdit','storegrupo']]);
        //  $this->middleware('permission:BORRAR-ROL', ['only' => ['destroy','eliminarmenu']]);
        //  $this->middleware('permission:VER-USUARIO', ['only' => ['buscarvista','creargrupo','buscarordengrupo','buscarmenus','buscarmenu','vistas','editarmenu']]);

    }

    public function index()
    {  
        $partes = Parte::orderBy('id_parte')->get();
        $empleados = Empleado::orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
        return view('Ingenieria.Servicios.Partes.index', compact('partes', 'empleados'));
    }

    // VISTAS DE PARTES
    public function obtenerPartes(Request $request, $tipo_orden){
        // return $request;
        $id_empleado = Auth::user()->getEmpleado->id_empleado;
        $supervisores = $this->obtenerSupervisores();
        $responsables = $this->obtenerEmpleados();
        $codigos_servicio = $this->obtenerCodigoServicio();
        $servicios = $request->input('cod_serv');
        $respo = $request->input('lid');
        $from = $request->input('fecha_desde');
        $to = $request->input('fecha_hasta');   
        $super = $request->input('sup');   
        //$estados = $this->listarTodosLosEstados();
        $tipo = '';
        $editable = '';
        // return Vw_parte_trabajo::whereBetween('fecha', [$from, $to])->get();
        //FILTRAMOS LAS PARTES POR TIP0
        switch ($tipo_orden) {           
            case 1:
                //PARTE DE TRABAJO
                if (Auth::user()->hasRole('SUPERVISOR') || Auth::user()->hasRole('ADMIN')) {
                    //SI ES SUPERVISOR TRAIGO TODAS LAS PARTES
                    $partes = Vw_parte_trabajo::servicio($servicios)->responsable($respo)->supervisor($super)->fecha($from, $to)->orderBy('id_parte', 'desc')->paginate(500);
                }else{
                    //SI NO ES SUPERVISOR TRAIGO SOLO LAS DEL EMPLEADO LOGUEADO
                    $editable = 'readonly';
                    $partes = Vw_parte_trabajo::servicio($servicios)->responsable([$id_empleado])->fecha($from, $to)->orderBy('id_parte', 'desc')->paginate(500);
                }
                $tipo = 'Trabajo';
                $estados = $this->listarTodosLosEstadosDe(1);
                break;
                
            case 2:
                //PARTE DE MANUFACTURA
                if (Auth::user()->hasRole('SUPERVISOR') || Auth::user()->hasRole('ADMIN')) {
                    //SI ES SUPERVISOR TRAIGO TODAS LAS PARTES
                    $partes = Vw_parte_manufactura::servicio($servicios)->responsable($respo)->supervisor($super)->fecha($from, $to)->orderBy('id_parte', 'desc')->get();
                }else{
                    //SI NO ES SUPERVISOR TRAIGO SOLO LAS DEL EMPLEADO LOGUEADO
                    $editable = 'readonly';
                    $partes = Vw_parte_manufactura::servicio($servicios)->responsable([$id_empleado])->fecha($from, $to)->orderBy('id_parte', 'desc')->get();
                }
                $tipo = 'Manufactura';
                $estados = $this->listarTodosLosEstadosDe(2);
                break;
            case 3:
                //PARTE DE MECANIZADO
                if (Auth::user()->hasRole('SUPERVISOR') || Auth::user()->hasRole('ADMIN')) {
                    //SI ES SUPERVISOR TRAIGO TODAS LAS PARTES
                    $partes = Vw_parte_mecanizado::servicio($servicios)->responsable($respo)->supervisor($super)->fecha($from, $to)->orderBy('id_parte', 'desc')->get();
                }else{
                    //SI NO ES SUPERVISOR TRAIGO SOLO LAS DEL EMPLEADO LOGUEADO
                    $editable = 'readonly';
                    $partes = Vw_parte_mecanizado::servicio($servicios)->responsable([$id_empleado])->fecha($from, $to)->orderBy('id_parte', 'desc')->get();
                }
                $tipo = 'Mecanizado';
                $estados = $this->listarTodosLosEstadosDe(3);
                break;
            case 4:
                //PARTE DE MANTENIMIENTO
                if (Auth::user()->hasRole('SUPERVISOR') || Auth::user()->hasRole('ADMIN')) {
                    //SI ES SUPERVISOR TRAIGO TODAS LAS PARTES
                    $partes = Vw_parte_mantenimiento::get();
                }else{
                    //SI NO ES SUPERVISOR TRAIGO SOLO LAS DEL EMPLEADO LOGUEADO
                    $editable = 'readonly';
                    $partes = Vw_parte_mantenimiento::responsable($id_empleado)->get();
                }
                $tipo = 'Mantenimiento';
                $estados = $this->listarTodosLosEstadosDe(1);
                break;
            default:
                # code...
                break;
        }

        $flt_serv = Servicio::orderBy('codigo_servicio')->get(['id_servicio', 'codigo_servicio']);
        $flt_resp = $this->obtenerEmpleados();
        $flt_sup = $this->obtenerSupervisores();

        return view('Ingenieria.Servicios.Partes.partes', compact('partes', 'supervisores', 'responsables', 'estados', 'tipo', 'tipo_orden', 'codigos_servicio', 'editable', 'flt_serv', 'flt_resp', 'flt_sup', 'servicios', 'respo', 'super', 'from', 'to'));
    }

    public function obtenerCodigoServicio(){
        return Servicio::orderBy('prioridad_servicio')->get(['id_servicio', 'codigo_servicio']);
    }
    public function obtenerEmpleados(){
        return Empleado::orderBy('nombre_empleado')->get();
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

    public function listarTodosLosEstadosDe($opcion){
        $estados_arr = array();

        switch ($opcion) {
            case 1:
                foreach (Estado::get() as $estado) {
                    array_push($estados_arr, (object)[
                        'id_estado' => $estado->id_estado,
                        'nombre' => $estado->nombre_estado
                    ]);
                }
                break; 
            case 2:
                foreach (Estado_manufactura::get() as $estado) {
                    array_push($estados_arr, (object)[
                        'id_estado' => $estado->id_estado_manufactura,
                        'nombre' => $estado->nombre_estado_manufactura
                    ]);
                }
                break;
            case 3:
                foreach (Estado_mecanizado::get() as $estado) {
                    array_push($estados_arr, (object)[
                        'id_estado' => $estado->id_estado_mecanizado,
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

    public function indexOrden($id, $tipo_orden){
        $orden = Orden::find(base64url_decode($id));

        if (Auth::user()->hasRole('SUPERVISOR')) {
            $editable = '';
            $editarEstado = 1;
            $estados = Estado::orderBy('id_estado')->pluck('nombre_estado', 'id_estado');
        } else {
            $editable = 'readonly';
            $estados = Estado::whereIn('id_estado', [1, 6, 7])->orderBy('nombre_estado')->pluck('nombre_estado', 'id_estado');
            $editarEstado = 0;

            if (in_array($orden->getIdEstado(), [1, 6, 7])) {
                $editarEstado = 1;
            }
        }

        $estados_manufactura = Estado_manufactura::orderBy('id_estado_manufactura')->pluck('nombre_estado_manufactura','id_estado_manufactura');
        $estados_mecanizado = Estado_mecanizado::orderBy('id_estado_mecanizado')->pluck('nombre_estado_mecanizado','id_estado_mecanizado');
        $maquinas = Maquinaria::orderBy('id_maquinaria')->pluck('alias_maquinaria','id_maquinaria');
       
        return view('Ingenieria.Servicios.Partes.show', compact('orden', 'editable', 'estados', 'estados_manufactura', 'estados_mecanizado', 'maquinas', 'tipo_orden', 'editarEstado'));
    }

    public function create(Request $request)
    {
        return view('Informatica.GestionUsuarios.roles.crear');
        $name = $request->query->get('name');

        if ($name =='') {
            //Con paginación
            $permission = Permission::orderBy('updated_at', 'desc')->get();
            return view('Coordinacion.Informatica.GestionUsuarios.roles.crear',compact('permission'));
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            $name = strtoupper($name);
            $permission = Permission::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->get();
            //$permission = Permission::whereRaw('UPPER(name) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('updated_at', 'desc')->get(); 
            return view('Coordinacion.Informatica.GestionUsuarios.roles.crear',compact('permission'));
        }
        
    }
    
    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'id_orden' => 'required',
            'observaciones' => 'required',
            'fecha_limite' => 'required',
            'fecha' => 'required',
            'horas' => 'required',
            'minutos' => 'required',
        ]);

        $orden = Orden::find($request->input('id_orden'));
        $responsable = $orden->getObjResponsable();
        $puesto = $responsable->getPuestoEmpleado;
        
        $fecha_limite = $request->input('fecha_limite');

        $fecha = $request->input('fecha');

        $observaciones = $request->input('observaciones');

        $opcion =  $orden->getOrdenDe->getTipoOrden();

        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');

        $horas = $request->input('horas') . ':' . $request->input('minutos');
        
        $costo = $request->input('horas')*$puesto->costo_hora + $request->input('minutos') * ($puesto->costo_hora/60);

        switch ($opcion) {
            case 1:
                $this->validate($request, [
                    'estado' => 'required'
                ]);

                $estado = $request->input('estado');

                $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();

                $responsabilidad = Responsabilidad::create([
                    'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                    'id_rol_empleado' => $rol_empleado->id_rol_empleado
                ]);

                $parte = Parte::create([
                            'observaciones' => $observaciones,
                            'fecha' => $fecha,
                            'fecha_limite' => $fecha_limite,
                            'fecha_carga' => $fecha_carga,
                            'horas' => $horas,
                            'costo' => $costo,
                            'id_orden' => $orden->id_orden,
                            'id_responsabilidad' => $responsabilidad->id_responsabilidad
                        ]);
                Parte_trabajo::create([
                    'id_estado' => $estado,
                    'id_parte' => $parte->id_parte
                ]);

                return redirect()->back()->with('mensaje','Parte de trabajo creado con éxito!.');
                // return redirect()->route('orden.partes', [base64url_encode($orden->id_orden), 1])->with('mensaje','Parte de trabajo creado con éxito!.');                       
                break;
            case 2:
                $this->validate($request, [
                    'estado' => 'required'
                ]);

                $estado = $request->input('estado');

                $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();

                $responsabilidad = Responsabilidad::create([
                    'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                    'id_rol_empleado' => $rol_empleado->id_rol_empleado
                ]);

                $parte = Parte::create([
                            'observaciones' => $observaciones,
                            'fecha' => $fecha,
                            'fecha_limite' => $fecha_limite,
                            'fecha_carga' => $fecha_carga,
                            'horas' => $horas,
                            'costo' => $costo,
                            'id_orden' => $orden->id_orden,
                            'id_responsabilidad' => $responsabilidad->id_responsabilidad
                        ]);
                Parte_manufactura::create([
                    'id_estado_manufactura' => $estado,
                    'id_parte' => $parte->id_parte
                ]);
                return redirect()->back()->with('mensaje','Parte de manufactura creado con éxito!.');
                //return redirect()->route('orden.partes', [base64url_encode($orden->id_orden), 2])->with('mensaje','Parte de manufactura creado con éxito!.');                       
                break;
            case 3:
                $this->validate($request, [
                    'estado' => 'required'
                ]);

                $estado = $request->input('estado');
                $horas_maquina = $request->input('horas_maquina') . ':' . $request->input('minutos_maquina');
                $maquina = $request->input('maquina');

                $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();

                $responsabilidad = Responsabilidad::create([
                    'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                    'id_rol_empleado' => $rol_empleado->id_rol_empleado
                ]);

                $parte = Parte::create([
                            'observaciones' => $observaciones,
                            'fecha' => $fecha,
                            'fecha_limite' => $fecha_limite,
                            'fecha_carga' => $fecha_carga,
                            'horas' => $horas,
                            'costo' => $costo,
                            'id_orden' => $orden->id_orden,
                            'id_responsabilidad' => $responsabilidad->id_responsabilidad
                        ]);
                $parte_mecanizado = Parte_mecanizado::create([
                    'id_estado_mecanizado' => $estado,
                    'id_parte' => $parte->id_parte
                ]);
                
                if ($maquina) {
                    Parte_mecanizado_x_maquinaria::create([
                        'id_parte_mecanizado' => $parte_mecanizado->id_parte_mecanizado,
                        'id_maquinaria' => $maquina,
                        'horas_maquina' => $horas_maquina
                    ]);
                }
                

                return redirect()->back()->with('mensaje','Parte de mecanizado creado con éxito!.');
                //return redirect()->route('orden.partes', [base64url_encode($orden->id_orden), 3])->with('mensaje','Parte de mecanizado creado con éxito!.');                       
                break;
            default:
                # code...
                break;
        }
        return 1;                      
    }
    
    public function show($idParte)
    {
        // $logs = Log_parte::where('id_parte', $idParte)->get();
        // return view('Ingenieria.Servicios.Partes.logs', compact('logs', 'idParte'));
    }
    public function obtenerLogs($idParte)
    {
        $logs = Log_parte::where('id_parte', $idParte)->get();
        return view('Ingenieria.Servicios.Partes.logs', compact('logs', 'idParte'));
    }
    
    public function edit(Request $request, $id)
    {
    }
    
    public function update(Request $request, $id)
    {                      
    }
    
    public function destroy($id)
    {      
    }
    
    public function obtenerPartesDeUnaOrden($id)
    {
        $orden = Orden::find($id);
        $partes_arr = array();

        foreach ($orden->getPartes as $parte) {
            if ($orden->getOrdenDe->getTipoOrden() == 3) {
                array_push($partes_arr, (object)[
                    'id_parte' => $parte->id_parte,
                    'observaciones' => $parte->observaciones,
                    'estado' => $parte->getParteDe->getNombreEstado(),
                    'responsable' => $parte->getResponsable->getEmpleado->nombre_empleado,
                    'id_res' => $parte->getResponsable->getEmpleado->id_empleado,
                    'fecha' => $parte->fecha,
                    'fecha_limite' => $parte->fecha_limite ?? '-',
                    'horas' => $parte->horas,
                    'supervisor' => $parte->getOrden->getSupervisor(),
                    'orden' => $orden->nombre_orden,
                    'etapa' => $orden->getEtapa->descripcion_etapa,
                    'estado_orden' => $orden->getEstado(),
                    'maquinaria' => $parte->getParteDe->getParteMecxMaq->first()->getMaquinaria->codigo_maquinaria ?? '-',
                    'horas_maquinaria' => $parte->getParteDe->getParteMecxMaq->first() ? $parte->getParteDe->getParteMecxMaq->first()->horas_maquina : '-'
                    ]);
            } else {
                array_push($partes_arr, (object)[
                    'id_parte' => $parte->id_parte,
                    'observaciones' => $parte->observaciones,
                    'estado' => $parte->getParteDe->getNombreEstado(),
                    'responsable' => $parte->getResponsable->getEmpleado->nombre_empleado,
                    'id_res' => $parte->getResponsable->getEmpleado->id_empleado,
                    'fecha' => $parte->fecha,
                    'fecha_limite' => $parte->fecha_limite ?? '-',
                    'horas' => $parte->horas,
                    'supervisor' => $parte->getOrden->getSupervisor(),
                    'orden' => $orden->nombre_orden,
                    'etapa' => $orden->getEtapa->descripcion_etapa,
                    'estado_orden' => $orden->getEstado(),
                    ]);
            } 
        }

        return $partes_arr;
    }

    public function obtenerParte($id){
        $parte = Parte::find($id);

        if (Auth::user()->hasRole('TECNICO')) {
            $es_tecnico = 1;
        } else {
            $es_tecnico = 0;
        }

        if ($parte->getParteDe->getTipoParte() != 3) {
            return [
                'id_orden' => $parte->id_orden,
                'id_parte' => $parte->id_parte,
                'observaciones' => $parte->observaciones,
                'horas' => $parte->horas,
                'estado' => $parte->getParteDe->getIdEstado(),
                'nombre_estado' => $parte->getParteDe->getNombreEstado(),
                'fecha' => $parte->fecha,
                'fecha_limite' => $parte->fecha_limite,
                'tec' => $es_tecnico
            ];
        } else {
            return [
                'id_parte' => $parte->id_parte,
                'observaciones' => $parte->observaciones,
                'horas' => $parte->horas,
                'estado' => $parte->getParteDe->getIdEstado(),
                'nombre_estado' => $parte->getParteDe->getNombreEstado(),
                'fecha' => $parte->fecha,
                'fecha_limite' => $parte->fecha_limite,
                'maquinaria' => $parte->getParteDe->getParteMecxMaq->first()->getMaquinaria->id_maquinaria ?? '-',
                'horas_maquinaria' => $parte->getParteDe->getParteMecxMaq->first() ? $parte->getParteDe->getParteMecxMaq->first()->horas_maquina : '-',
                'tec' => $es_tecnico
            ];
        }
    }

    public function ultimoParteOrden($id){
        $orden = Orden::find($id);
        $ultimo_parte = $orden->getPartes->last();
        switch ($orden->getOrdenDe->getTipoOrden()) {
            case 1:
                $orden = Vw_orden_trabajo::find($id);
                break;
            case 2:
                $orden = Vw_orden_manufactura::find($id);
                break;
            case 3:
                $orden = Vw_orden_mecanizado::find($id);
                break;
            default:
                # code...
                break;
        }
        return [
            'nombre_orden' => $orden->nombre_orden,
            'fecha_limite' => $ultimo_parte->fecha_limite,
            'estado' => $ultimo_parte->getParteDe->getEstado->nombre_estado,
            'total_horas' => $orden->total_horas,
            'responsable' => $orden->responsable
        ];
    }

    public function guardarActualizarParte(Request $request)
    {

        $this->validate($request, [
            'id_orden' => 'required',
            'observaciones' => 'required',
            'fecha_limite' => 'required',
            'fecha' => 'required',
            'horas' => 'required',
            'minutos' => 'required',
            'estado' => 'required'
        ]);

        $orden = Orden::find($request->input('id_orden'));

        $estado_actual = $orden->getIdEstado();
       
        $editar = $request->input('editar');

        if ($request->input('id_parte')) {
            $parte = Parte::find($request->input('id_parte'));
            $res = $parte->getResponsable->id_empleado;

            if ($editar == 1 && $res != Auth::user()->getEmpleado->id_empleado && !Auth::user()->hasRole('SUPERVISOR')) {
                return 6;
                return 'No se puede editar un parte de la cual no es responsable';
            }
        }     

        $responsable = $orden->getObjResponsable();

        $puesto = $responsable->getPuestoEmpleado;

        $estado = $request->input('estado');
        
        $fecha_limite = $request->input('fecha_limite');

        $fecha = $request->input('fecha');

        $observaciones = $request->input('observaciones');

        $opcion =  $orden->getOrdenDe->getTipoOrden();

        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');

        $horas = $request->input('horas') . ':' . $request->input('minutos');
        
        $costo = $request->input('horas')*$puesto->costo_hora + $request->input('minutos') * ($puesto->costo_hora/60);

        switch ($opcion) {
            case 1:
                if ($editar){
                    //return 2;
                    Log_parte::create([
                        'id_parte' => $parte->id_parte,
                        'id_responsabilidad' => $parte->id_responsabilidad,
                        'observaciones' => $parte->observaciones,
                        'fecha' => $parte->fecha,
                        'fecha_limite' => $parte->fecha_limite,
                        'fecha_carga' => $fecha_carga,
                        'horas' => $parte->horas,
                        'estado' => $parte->getParteDe->getNombreEstado(),
                        'responsable_cambio' => Auth::user()->getEmpleado->id_empleado
                    ]);
                    
                    $parte->update([
                        'observaciones' => $observaciones,
                        'fecha' => $fecha,
                        'horas' => $horas
                    ]);

                    if (Auth::user()->hasRole('SUPERVISOR')) {
                        $parte->update([
                            'fecha_limite' => $fecha_limite
                        ]);
                    }

                    $parte->getParteDe->update([
                        'id_estado' => $estado
                    ]);
                    $result = 2;
                }else{
                    $estado = $request->input('estado');

                    $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();

                    $responsabilidad = Responsabilidad::create([
                        'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                        'id_rol_empleado' => $rol_empleado->id_rol_empleado
                    ]);

                    $parte = Parte::create([
                                'observaciones' => $observaciones,
                                'fecha' => $fecha,
                                'fecha_limite' => $fecha_limite,
                                'fecha_carga' => $fecha_carga,
                                'horas' => $horas,
                                'costo' => $costo,
                                'id_orden' => $orden->id_orden,
                                'id_responsabilidad' => $responsabilidad->id_responsabilidad
                            ]);
                    Parte_trabajo::create([
                        'id_estado' => $estado,
                        'id_parte' => $parte->id_parte
                    ]);

                    if ($estado_actual != $estado) {
                        $this->enviarEmail($parte->id_parte, $estado, $opcion);
                    }

                    $result = 1;
                }
                return[
                    'resultado' => $result,
                    'tipo_orden' => $opcion
                ];
                break;

            case 2:
                if ($editar) {

                    Log_parte::create([
                        'id_parte' => $parte->id_parte,
                        'id_responsabilidad' => $parte->id_responsabilidad,
                        'observaciones' => $parte->observaciones,
                        'fecha' => $parte->fecha,
                        'fecha_limite' => $parte->fecha_limite,
                        'fecha_carga' => $fecha_carga,
                        'horas' => $parte->horas,
                        'estado' => $parte->getParteDe->getNombreEstado(),
                        'responsable_cambio' => Auth::user()->getEmpleado->id_empleado
                    ]);

                    $parte->update([
                        'observaciones' => $observaciones,
                        'fecha_limite' => $fecha_limite,
                        'fecha' => $fecha,
                        'horas' => $horas
                    ]);

                    $parte->getParteDe->update([
                        'id_estado_manufactura' => $estado
                    ]);

                    $result = 2;
                } else {
                    $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();

                    $responsabilidad = Responsabilidad::create([
                        'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                        'id_rol_empleado' => $rol_empleado->id_rol_empleado
                    ]);

                    $parte = Parte::create([
                                'observaciones' => $observaciones,
                                'fecha' => $fecha,
                                'fecha_limite' => $fecha_limite,
                                'fecha_carga' => $fecha_carga,
                                'horas' => $horas,
                                'costo' => $costo,
                                'id_orden' => $orden->id_orden,
                                'id_responsabilidad' => $responsabilidad->id_responsabilidad
                            ]);
                    Parte_manufactura::create([
                        'id_estado_manufactura' => $estado,
                        'id_parte' => $parte->id_parte
                    ]);
                    $result = 1;
                }

                return[
                    'resultado' => $result,
                    'tipo_orden' => $opcion
                ];                      
                break;
            
            case 3:
                if ($editar) {
                    $log_parte = Log_parte::create([
                        'id_parte' => $parte->id_parte,
                        'id_responsabilidad' => $parte->id_responsabilidad,
                        'observaciones' => $parte->observaciones,
                        'fecha' => $parte->fecha,
                        'fecha_limite' => $parte->fecha_limite,
                        'fecha_carga' => $fecha_carga,
                        'horas' => $parte->horas,
                        'estado' => $parte->getParteDe->getNombreEstado(),
                        'responsable_cambio' => Auth::user()->getEmpleado->id_empleado
                    ]);

                    if ($parte->getParteDe->getParteMecxMaq->first()) {
                        $log_parte->update([
                            'id_maquinaria' => $parte->getParteDe->getParteMecxMaq->first()->id_maquinaria,
                            'horas_maquina' => $parte->getParteDe->getParteMecxMaq->first()->horas_maquina
                        ]);
                    }

                    $horas_maquina = $request->input('horas_maquina') . ':' . $request->input('minutos_maquina');
                    $maquina = $request->input('maquina');

                    $parte->update([
                        'observaciones' => $observaciones,
                        'fecha_limite' => $fecha_limite,
                        'fecha' => $fecha,
                        'horas' => $horas
                    ]);

                    $parte->getParteDe->update([
                        'id_estado_mecanizado' => $estado
                    ]);

                    if ($maquina) {
                        $parte->getParteDe->getParteMecxMaq->first()->update([
                            'id_maquinaria' => $maquina,
                            'horas_maquina' => $horas_maquina
                        ]);
                    }

                    $result = 2;

                } else {
                    $horas_maquina = $request->input('horas_maquina') . ':' . $request->input('minutos_maquina');
                    $maquina = $request->input('maquina');

                    $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();

                    $responsabilidad = Responsabilidad::create([
                        'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                        'id_rol_empleado' => $rol_empleado->id_rol_empleado
                    ]);

                    $parte = Parte::create([
                                'observaciones' => $observaciones,
                                'fecha' => $fecha,
                                'fecha_limite' => $fecha_limite,
                                'fecha_carga' => $fecha_carga,
                                'horas' => $horas,
                                'costo' => $costo,
                                'id_orden' => $orden->id_orden,
                                'id_responsabilidad' => $responsabilidad->id_responsabilidad
                            ]);
                    $parte_mecanizado = Parte_mecanizado::create([
                        'id_estado_mecanizado' => $estado,
                        'id_parte' => $parte->id_parte
                    ]);
                    
                    if ($maquina) {
                        Parte_mecanizado_x_maquinaria::create([
                            'id_parte_mecanizado' => $parte_mecanizado->id_parte_mecanizado,
                            'id_maquinaria' => $maquina,
                            'horas_maquina' => $horas_maquina
                        ]);
                    }
                    $result = 1;
                }
                return[
                    'resultado' => $result,
                    'tipo_orden' => $opcion
                ];        
                             
                break;

            default:
                # code...
                break;

        }
        return 1;    
    }

    public function pruebaEmail(){
        $email = "lisandrosilvero@gmail.com";
        $tipo = 'Trabajo';
        $responsable = 'Juan';
        $proyecto = 'Proyecto titulo';
        $codigo = 123;
        $estado = 'revisar';
        $nombre = 'luciano';
        $estado_nom = 'Espera';
        $codigo_pr = 140;
        $etapa = 'etapa';
        $orden = 'orden';
        $tipo_ord = 1;
        Mail::to($email)->send(new ParteMailable($nombre, $codigo, $tipo, $responsable, $proyecto, $estado_nom, $codigo_pr, $etapa, $orden, $tipo_ord, 1));
    }

    public function emailSemanal(){

        $users = User::role('TECNICO')->get();
        Mail::to($email)->send(new SendScheduledMail($users));

        $userPrue = User::role('SUPERVISOR')->get();
        Mail::to($email)->send(new SendScheduledMailResSuper($userPrue));

    }

    public function enviarEmail($id_parte, $estado, $opcion){

        $parte = Parte::find($id_parte);
        $responsable = $parte->getOrden->getNombreResponsable();
        $nombre = $parte->getOrden->getSupervisor();
        $proyecto = $parte->getOrden->getEtapa->getServicio->codigo_servicio;
        $codigo = 123;
        $estado_nom = Estado::find($estado)->nombre_estado;
        $codigo_pr = $parte->getOrden->getEtapa->getServicio->id_servicio;
        $etapa = $parte->getOrden->getEtapa->descripcion_etapa;
        $orden = $parte->getOrden->nombre_orden;
        $empleado = $parte->getOrden->getObjSupervisor();
        $obj_res = $parte->getOrden->getObjResponsable();
        switch ($opcion) {
            case 1:
                $tipo_ord = 1;
                $tipo = 'trabajo';
                
                if ($estado == 6 || $estado == 7) { //Revisar y problema se notifica al supervisor
                    try {
                        $email = $parte->getOrden->getEmailSupervisor();
                        Mail::to($email)->send(new ParteMailable($nombre, $codigo, $tipo, $responsable, $proyecto, $estado_nom, $codigo_pr, $etapa, $orden, $tipo_ord, 1));

                        $notif = Not_notificacion_cuerpo::create([
                            'titulo' => 'Cambio estado Orden de trabajo',
                            'mensaje' => $responsable.' ha cambiado el estado de la orden "'.$orden.'" a '.$estado_nom.'.',
                            'url' => '/ordenes/1'
                        ]);
                        
                        Not_notificacion::create([
                            'user_id' =>  $empleado->user_id,
                            'id_not_cuerpo' => $notif->id_not_cuerpo,
                            'tipo' => 'noti_web',
                        ]);
                    } catch (\Throwable $th) {
                         //throw $th;
                    }
                }
        
                if ($estado == 1 || $estado == 9 || $estado == 10) { //En proceso, Completo y cancelado se notifica al responsable
                    try {
                        $email = $parte->getOrden->getEmailResponsable();
                        Mail::to($email)->send(new ParteMailable($nombre, $codigo, $tipo, $responsable, $proyecto, $estado_nom, $codigo_pr, $etapa, $orden, $tipo_ord, 2));

                        $notif = Not_notificacion_cuerpo::create([
                            'titulo' => 'Cambio estado Orden de trabajo',
                            'mensaje' => $nombre.' ha cambiado el estado de la orden "'.$orden.'" a '.$estado_nom.'.',
                            'url' => '/ordenes/1'
                        ]);
                        
                        Not_notificacion::create([
                            'user_id' =>  $obj_res->user_id,
                            'id_not_cuerpo' => $notif->id_not_cuerpo,
                            'tipo' => 'noti_web',
                        ]);
                    } catch (\Throwable $th) {
                         //throw $th;
                    }
                }
                break;

            case 2:
                $tipo_ord = 2;
                $tipo = 'Manufactura';
                break;
            case 3:
                $tipo_ord = 3;
                $tipo = 'Mecanizado';
                break;
            default:
                # code...
                break;
        }

    }

    public function guardarMultipleParte(Request $request){
        // return 'holi';
       return $ids_orden = $request->input('ids');
    }
}