<?php

namespace App\Http\Controllers\Ingenieria\Solicitud\SMA;
use App\Http\Controllers\Controller;

use App\Models\Cambre\Accion_para_tarea;
use App\Models\Cambre\Maquinaria;
use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

use App\Models\Cambre\Sol_prioridad_solicitud;
use App\Models\Cambre\Sol_servicio_de_ingenieria;
use App\Models\Cambre\Sol_estado_solicitud;
use App\Models\Cambre\Sol_solicitud;
use App\Models\Cambre\Sol_archivo_solicitud;
use App\Models\Cambre\Sol_servicio_de_mantenimiento;
use App\Models\Cambre\Sector;
use App\Models\Cambre\Activo;
use App\Models\Cambre\Empleado;
use App\Models\Cambre\Subtipo_servicio;
use App\Models\Cambre\Servicio;
use App\Models\Cambre\Servicio_info;
use App\Models\Cambre\Etapa;
use App\Models\Cambre\Actualizacion;
use App\Models\Cambre\Actualizacion_servicio;
use App\Models\Cambre\Actualizacion_etapa;
use App\Models\Cambre\Orden;
use App\Models\Cambre\Orden_mantenimiento;
use App\Models\Cambre\Orden_mecanizado;
use App\Models\Cambre\Orden_mecanizado_asoc;
use App\Models\Cambre\Parte;
use App\Models\Cambre\Parte_diagnostico;
use App\Models\Cambre\Parte_mecanizado;
use App\Models\Cambre\Prefijo_proyecto;
use App\Models\Cambre\Estado;
use App\Models\Cambre\Not_notificacion_cuerpo;
use App\Models\Cambre\Not_notificacion;
use App\Models\Cambre\Rol_empleado;
use App\Models\Cambre\Responsabilidad;
use App\Models\Cambre\Responsabilidad_orden;
use App\Mail\Solicitud\SsiMailable;
use App\Models\Cambre\Em_not_x_empleado;
use App\Models\Cambre\Sintoma;
use App\Models\Cambre\Tipo_sintoma;
use App\Models\Cambre\Tipo_activo_x_sintoma;
use App\Models\Cambre\Activo_x_sintoma;
use App\Models\Cambre\Sol_serv_man_x_sintoma;
use App\Models\Cambre\Ishikawa_categoria;
use App\Models\Cambre\Ishikawa_causa;
use App\Models\Cambre\Zona;
use App\Models\Cambre\Vw_gest_orden_mecanizado;
use App\Models\Cambre\Estado_mecanizado;
use App\Models\Cambre\Tarea_mantenimiento;

class MantenimientoDeActivoController extends Controller
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
        
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'ssi_mant_id_prioridad' => 'required',
            'ssi-mant-descripcion' => 'required|string|max:500',
            'ssi_mant_id_activo' => 'required'
        ]);

        try {    
            DB::beginTransaction();

            $nombre = Auth::user()->getEmpleado->nombre_empleado;
            $descrip = $request->input('ssi-mant-descripcion');
            $prioridad = $request->input('ssi_mant_id_prioridad');
            $sintomas = $request->input('sintomas');

            if($request->input('fecha_req')){
                $fecha_requerida = $request->input('fecha_req');
            }else{
                $fecha_requerida = null;
            }
            
            $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
            $estado = Sol_estado_solicitud::where('id_estado_solicitud', 1)->first()->id_estado_solicitud;
            $activo = $request->input('ssi_mant_id_activo');
            
            $Solicitud = Sol_solicitud::create([
                'id_prioridad_solicitud' => $prioridad,
                'id_estado_solicitud' => $estado,
                'nombre_solicitante' => $nombre,
                'descripcion_solicitud' => $descrip,
                'fecha_carga' => $fecha_carga,
                'fecha_requerida' => $fecha_requerida,
                'id_empleado' => Auth::user()->getEmpleado->id_empleado
            ]);

            /*if ($request->hasFile('archivos')) {
                $cont = 1;
                foreach ($request->file('archivos') as $file) {

                    $filename = $Solicitud->id_solicitud . '-ssi_archivo_' . $cont . '_' . str_replace(" " ,"-", $nombre) . '.' . $file->extension();
                    $path = $file->storeAs('', $filename, 'public_arc_sol');
                    
                    Sol_archivo_solicitud::create([
                        'id_solicitud' => $Solicitud->id_solicitud,
                        'nombre_archivo' => $filename,
                        'ruta' => 'storage/solicitud/'.$path
                    ]);
                    $cont++;
                }
            }*/
            $Req_mant = Sol_servicio_de_mantenimiento::create([
                'id_solicitud' => $Solicitud->id_solicitud,
                'id_servicio_requerido' => 1,
                'id_activo' => $activo,
                'id_sector' => Auth::user()->getEmpleado->getSector->id_sector
            ]);

            
            foreach ($sintomas as $sintoma) {
                Sol_serv_man_x_sintoma::create([
                    'id_sintoma' => $sintoma,
                    'id_servicio_de_mantenimiento' => $Req_mant->id_servicio_de_mantenimiento
                ]);
            }
            
            
            
            /*
            try {
                $email_aviso = Em_not_x_empleado::where('id_em_notificacion', 1)
                                                        ->with('getEmpleado:id_empleado,email_empleado') // Cargar la relación con solo los campos necesarios
                                                        ->get()
                                                        ->pluck('getEmpleado.email_empleado')
                                                        ->all();
                $nombre = $Solicitud->getEmpleado->nombre_empleado;
                $codigo = $Solicitud->id_solicitud;
                $email = strval(Auth::user()->getEmpleado->email_empleado);
                // $email_aviso = explode(',', config('myconfig.ssi_email_admin'));
                Mail::to($email)->send(new SsiMailable($nombre, $codigo, 1));
                Mail::to($email_aviso)->send(new SsiMailable($nombre, $codigo, 4));

                //notificaciones web a supervisores
                $not_avs = Em_not_x_empleado::where('id_em_notificacion', 1)->get('id_empleado');
                $notif = Not_notificacion_cuerpo::create([
                    'titulo' => 'Nuevo SSI',
                    'mensaje' => $nombre.' ha creado un nuevo ssi con el codigo #'.$codigo.'.',
                    'url' => '/s_s_i'
                ]);
                foreach ($not_avs as $not_av) {
                    Not_notificacion::create([
                        'user_id' =>  Empleado::find($not_av->id_empleado)->user_id,
                        'id_not_cuerpo' => $notif->id_not_cuerpo,
                        'tipo' => 'noti_web',
                    ]);
                }
            } catch (\Throwable $th) {
                //throw $th;
        } */

        

        
    
            DB::commit();

            return redirect()->route('s_s_i.index')->with('mensaje', 'Solicitud de servicio de mantenimiento creado con exito.');                      
    
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                             ->with('error', 'Ocurrio un problema al crear la solicitud de servicio de mantenimiento: '.$e->getMessage());
        }                    
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
        $Tipos_servicios = Subtipo_servicio::where('id_subtipo_servicio', 5)->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        
        $supervisores_user = User::role('SUPERVISOR')->get();

        foreach ($supervisores_user as $supervisor_user) {
            $id_supervisor[] = $supervisor_user->id;
        }

        $empleados = $this->obtenerSupervisoresAdmin();
        $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        $prefijos = Prefijo_proyecto::orderBy('nombre_prefijo_proyecto')->pluck('nombre_prefijo_proyecto', 'id_prefijo_proyecto');
        $activos = Activo::orderBy('codigo_activo')->whereNotNull('codigo_activo')->pluck('codigo_activo', 'id_activo');

        return view('Ingenieria.Solicitud.SSI.Evaluar', compact('Ssi', 'Tipos_servicios', 'empleados', 'prioridadMax', 'prefijos', 'activos'));
    }

    public function rechazar($id){
        $solicitud = Sol_solicitud::find($id);
        $solicitud->id_estado_solicitud = 3;
        $solicitud->save();

        // try {
        //     $nombre = $solicitud->getEmpleado->nombre_empleado;
        //     $codigo = $solicitud->id_solicitud;
        //     $email = strval($solicitud->getEmpleado->email_empleado);
        //     Mail::to($email)->send(new SsiMailable($nombre, $codigo, 3));
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }

        return redirect()->route('s_s_i.index')->with('mensaje', 'Solicitud de servicio de mantenimiento de activo rechazada con exito.');  
    }

    public function aceptar(Request $request, $id){

        // return $request;
        try {    
            DB::beginTransaction();

            $id_estado_solicitud = Sol_estado_solicitud::where('nombre_estado_solicitud', 'aceptado')->first()->id_estado_solicitud;

            $solicitud = Sol_solicitud::find($id);

            $solicitud->update([
                'id_estado_solicitud' => $id_estado_solicitud
            ]);

            $id_servicio = $this->guardarServicioMantenimiento($request, $solicitud);


            $solicitud->update([
                'id_servicio' => $id_servicio
            ]);
        
            DB::commit();

            return redirect()->route('servicio_mantenimiento.gestionar', $id_servicio)->with('mensaje', 'El servicio de mantenimiento se ha creado con exito.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                             ->with('error', 'Ocurrio un problema al aceptar la solicitud de mantenimiento de activo: '.$e->getMessage());
        } 
    }

    public function guardarServicioMantenimiento($request, $solicitud){
        $activo = $solicitud->getServicioDeIngenieria->id_activo;

        $existeServicioMant = Servicio::where('id_subtipo_servicio', 6)->where('id_activo', $solicitud->getServicioDeIngenieria->id_activo)->orderBy('id_servicio', 'desc')->first();

        if ($existeServicioMant) {
            $ultNombre = $existeServicioMant->codigo_servicio;
            // obtener los últimos 4 caracteres
            $numeroNom = substr($ultNombre, -4);

            // pasarlo a entero y sumar 1
            $nuevoNumero = (int)$numeroNom + 1;

            // volver a formatear a 4 dígitos
            $numServ = str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
        } else {
            $numServ = '0001';
        }

        $codActivo = Activo::find($activo)->codigo_activo;

        // $numServ = 0001;

        $codigo_proyecto = $codActivo.'-MAN-'.$numServ;

        $nombre_proyecto = $codActivo.'-MAN-'.$numServ;

        $lider = $request->input('lider');

        $fecha_ini = $request->input('fecha_ini');
        $fecha_req = $request->input('fecha_req');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');

        if (1) {
            $prioridadMax = null;
        }else{
            $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        }
        
        $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'lider')->first();

        if (1) {
            $estado = Estado::where('nombre_estado', 'En proceso')->first();
        } else {
            $estado = Estado::where('nombre_estado', 'espera')->first();
        }
        
        $tipo_servicio = Subtipo_servicio::where('nombre_subtipo_servicio', 'Servicio de mantenimiento')->first()->id_subtipo_servicio;

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
            'descripcion' => 'Creacion de servicio de mantenimiento.',
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

        //Crear orden de mantenimiento de tipo diagnostico
        $id_responsable = Auth::user()->getEmpleado->id_empleado;
        $id_supervisor = $request->input('lider');
        $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first()->id_rol_empleado;
        $rol_empleado_supervisor = Rol_empleado::where('nombre_rol_empleado', 'supervisor')->first()->id_rol_empleado;

        $responsabilidad = Responsabilidad::create([
            'id_empleado' => $id_responsable,
            'id_rol_empleado' => $rol_empleado
        ]);

        $responsabilidad_supervisor = Responsabilidad::create([
            'id_empleado' => $id_supervisor,
            'id_rol_empleado' => $rol_empleado_supervisor
        ]);

        $orden = Orden::create([
                    'nombre_orden' => $nombre_proyecto.'-DIAGNÓSTICO',
                    'fecha_inicio' => $fecha_ini,
                    'id_etapa' => $etapa->id_etapa
                ]);

        Responsabilidad_orden::create([
            'id_responsabilidad' => $responsabilidad->id_responsabilidad,
            'id_orden' => $orden->id_orden
        ]);

        Responsabilidad_orden::create([
            'id_responsabilidad' => $responsabilidad_supervisor->id_responsabilidad,
            'id_orden' => $orden->id_orden
        ]);
        
        Orden_mantenimiento::create([
            'id_tipo_orden_mantenimiento' => 1,
            'id_orden' => $orden->id_orden,
            'esta_activo' => 1
        ]);

        $responsabilidad_parte = Responsabilidad::create([
            'id_empleado' => 999,
            'id_rol_empleado' => $rol_empleado
        ]);
        
        $parte = Parte::create([
            'observaciones' => 'Generacion de orden de mantenimiento de diagnostico',
            'fecha' => $fecha_ini,
            'fecha_limite' => $fecha_req,
            'fecha_carga' => $fecha_carga,
            'horas' => '00:00',
            'id_orden' => $orden->id_orden,
            'id_responsabilidad' => $responsabilidad_parte->id_responsabilidad
        ]);

        Parte_diagnostico::create([
            'id_parte' => $parte->id_parte, 
            'id_estado' => 1,
            'en_maquina' => 0,
            'en_banco' => 0
        ]);


        return $proyecto->id_servicio;
    }

    public function gestionar($id){
        $proyecto = Servicio::find($id);
        $solicitud = Sol_solicitud::where('id_servicio', $id)->first();
        $ishikawa_categorias = Ishikawa_categoria::orderBy('nombre_categoria')->get();
        $ishikawa_causas = Ishikawa_causa::orderBy('nombre_causa')->get();
        $acciones = Accion_para_tarea::orderBy('nombre_accion')->get();
        $ordenes_mantenimiento = Orden::join('orden_mantenimiento as om', 'om.id_orden', '=', 'orden.id_orden')
                                ->where('orden.id_etapa', $proyecto->getEtapas->first()->id_etapa)->get();
        $zonas = Zona::orderBy('nombre_zona')->get();
        $tareas_mantenimiento = Tarea_mantenimiento::orderBy('nombre_tarea')
        ->leftJoin('tipo_activo_x_tarea_mant', 'tipo_activo_x_tarea_mant.id_tarea_mantenimiento', '=', 'tarea_mantenimiento.id_tarea_mantenimiento')
        ->leftJoin('activo_x_tarea_mant', 'activo_x_tarea_mant.id_tarea_mantenimiento', '=', 'tarea_mantenimiento.id_tarea_mantenimiento')
        ->where('activo_x_tarea_mant.id_activo', $proyecto->id_activo)
        ->orWhere('tipo_activo_x_tarea_mant.id_tipo_activo', $proyecto->getActivo->id_tipo_activo)
        ->get();
        
        
        //todas las maquinas
        // $maquinas = Maquinaria::orderBy('alias_maquinaria')->get();

        //Maquinas del usuario
        if (Auth::user()->hasRole('SUPERVISOR') || Auth::user()->hasRole('ADMIN')) {
            $maquinas = Maquinaria::orderBy('alias_maquinaria')->get();
        }else{
            $maquinas = DB::table('maquinaria as maq')
                        ->join('emp_x_maq as exp', 'exp.id_maquinaria', '=', 'maq.id_maquinaria')
                        ->where('exp.id_empleado', Auth::user()->getEmpleado->id_empleado)
                        ->get();
        }
        

        $ordenes_mecanizado = Vw_gest_orden_mecanizado::where('id_servicio', $id)->get();
        $estados_mecanizado = Estado_mecanizado::pluck('nombre_estado_mecanizado', 'id_estado_mecanizado');
        $supervisores = $this->obtenerSupervisores()->pluck('nombre_empleado', 'id_empleado');
        //todos los empleados
        // $empleados = Empleado::where('esta_activo', 1)->orderBy('nombre_empleado')->get();

        //todos los empleados con la operacion "AJUSTE"
        $empleados = DB::table('empleado as emp')
                        ->join('emp_x_maq as exp', 'exp.id_empleado', '=', 'emp.id_empleado')
                        ->join('maquinaria as maq', 'maq.id_maquinaria', '=', 'exp.id_maquinaria')
                        ->join('ope_x_maq as oxm', 'oxm.id_maquinaria', '=', 'maq.id_maquinaria')
                        ->join('operacion as op', 'op.id_operacion', '=', 'oxm.id_operacion')
                        ->where('op.id_operacion', 2)
                        ->select('emp.id_empleado', 'emp.nombre_empleado') // opcional, podés ajustar
                        ->orderBy('emp.nombre_empleado')
                        ->get();
        return view('Ingenieria.Servicios.Mantenimiento.gestionar', compact('empleados', 'proyecto', 'solicitud', 'ishikawa_categorias', 'ishikawa_causas', 
        'acciones', 'ordenes_mantenimiento', 'zonas', 'maquinas', 'ordenes_mecanizado', 'estados_mecanizado', 'supervisores', 'tareas_mantenimiento'));
    }

    public function destroy($id)
    {
                       
    }

    public function sma_obtener_causas($id){
        $activo = Activo::findOrFail($id);

        $idsTipo = Tipo_activo_x_sintoma::where(
            'id_tipo_activo',
            $activo->getTipoActivo->id_tipo_activo
        )->pluck('id_sintoma');

        $idsActivo = Activo_x_sintoma::where(
            'id_activo',
            $id
        )->pluck('id_sintoma');

        $idsSintomas = $idsTipo->merge($idsActivo)->unique()->values();

        $tipos = Tipo_sintoma::whereHas('getSintomas', function ($q) use ($idsSintomas) {
            $q->whereIn('id_sintoma', $idsSintomas);
        })
        ->with(['getSintomas' => function ($q) use ($idsSintomas) {
            $q->whereIn('id_sintoma', $idsSintomas);
        }])
        ->get();

        return $tipos->mapWithKeys(function ($tipo) {
            return [
                $tipo->id_tipo_sintoma => [
                    'tipo' => $tipo->nombre_tipo_sintoma,
                    'sintomas' => $tipo->getSintomas->map(fn($s) => [
                        'id' => $s->id_sintoma,
                        'nombre' => ucfirst($s->nombre_sintoma)
                    ])->values()
                ]
            ];
        });
    }

    public function ssi_man_ver_evaluar($id){
        $sma = Sol_servicio_de_mantenimiento::find($id);
        return view('Ingenieria.Solicitud.SMA.evaluar', compact('sma'));
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
        return Empleado::whereIn('id_empleado', $id_supervisores)->orderBy('nombre_empleado')->activo()->get();
    }

    public function guardarOrdenMecanizado(Request $request, $id){
        
        $this->validate($request, [
            'nom_orden' => 'required',
            'supervisor' => 'required',
            'revision' => 'required',
            'cantidad' => 'required',
            'fecha_ini' => 'required',
            'fecha_req' => 'required',
            'ruta_plano' => 'required',
            'estado_mecanizado' => 'required',
        ], [
            'nom_orden.required' => 'No se agrego el nombre de la orden',
            'supervisor.required' => 'Seleccione un supervisor'
        ]);

        $id_etapa = $id;
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
        $rol_empleado_supervisor = Rol_empleado::where('nombre_rol_empleado', 'supervisor')->first();
        $id_supervisor = $request->input('supervisor');
        $id_orden_manufactura = $request->input('id_orden_manuf');

        $ordenTrabajoCompar = $request->input('ord-tra-asoc');
        $idOrdenMecanizadoAsoc = $request->input('ord-mec-asoc');

        $esRetrabajo = $request->input('esRetrabajo') ?? 0;
        $esModificacion = $request->input('esModificacion') ?? 0;

        try {    
            DB::beginTransaction();
        
            $responsabilidad = Responsabilidad::create([
                'id_empleado' => $id_supervisor,
                'id_rol_empleado' => $rol_empleado->id_rol_empleado
            ]);

            $responsabilidad_supervisor = Responsabilidad::create([
                'id_empleado' => $id_supervisor,
                'id_rol_empleado' => $rol_empleado_supervisor->id_rol_empleado
            ]);

            $orden = Orden::create([
                        'nombre_orden' => $nombre_orden,
                        // 'duracion_estimada' => $duracion_estimada,
                        'duracion_estimada' => '00:00',
                        'fecha_inicio' => $fecha_ini,
                        'id_etapa' => $id_etapa,
                        'observaciones' => $observaciones
                    ]);
            

            Responsabilidad_orden::create([
                'id_responsabilidad' => $responsabilidad->id_responsabilidad,
                'id_orden' => $orden->id_orden
            ]);

            $responsabilidad = Responsabilidad_orden::create([
                'id_responsabilidad' => $responsabilidad_supervisor->id_responsabilidad,
                'id_orden' => $orden->id_orden
            ]);

            //Calculamos los costos despues de asignar responsabilidades
            // $orden->costo_estimado = $orden->getCostoEstimado();
            $orden->save();

            $ord_mec = Orden_mecanizado::create([
                'revision' => $revision,
                'cantidad' => $cantidad,
                'ruta_pieza' => $ruta_plano,
                'id_orden' => $orden->id_orden,
                'id_orden_manufactura' => $id_orden_manufactura,
                'es_modificacion' => $esRetrabajo,
                'es_retrabajo' => $esModificacion
            ]);

            if ($ordenTrabajoCompar || $idOrdenMecanizadoAsoc) {
                Orden_mecanizado_asoc::create([
                    'id_orden_mecanizado' => $ord_mec->id_orden_mecanizado,
                    'id_orden_mec_asoc' => $idOrdenMecanizadoAsoc,
                    'ord_tra_compar' => $ordenTrabajoCompar
                ]); 
            }

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
    
            DB::commit();

            return redirect()->back()->with('mensaje', 'La orden de mecanizado fue creado con exito.');                      
    
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                             ->with('error', 'Ocurrio un problema al crear la orden de mecanizado: '.$e->getMessage());
        }
    }
}