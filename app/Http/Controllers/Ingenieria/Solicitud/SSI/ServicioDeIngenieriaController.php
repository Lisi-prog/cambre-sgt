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
use App\Models\Cambre\Prefijo_proyecto;
use App\Models\Cambre\Estado;
use App\Models\Cambre\Not_notificacion_cuerpo;
use App\Models\Cambre\Not_notificacion;
use App\Mail\Solicitud\SsiMailable;
use App\Models\Cambre\Em_not_x_empleado;
use App\Models\Cambre\Sintoma;
use App\Models\Cambre\Tipo_sintoma;
use App\Models\Cambre\Tipo_activo_x_sintoma;
use App\Models\Cambre\Sol_serv_man_x_sintoma;
use App\Models\Cambre\Sol_serv_ing_x_sintoma;

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
        $Prioridades = Sol_prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')
            ->pluck('nombre_prioridad_solicitud', 'id_prioridad_solicitud');
        $activos = Activo::orderBy('codigo_activo')->whereNotNull('codigo_activo')
            ->pluck('codigo_activo', 'id_activo');

        return view('Ingenieria.Solicitud.SSI.index', compact('Prioridades', 'activos'));
    }

    public function datos(Request $request)
    {
        $request->validate([
            'draw' => 'required|integer|min:0',
            'start' => 'required|integer|min:0',
            'length' => 'required|integer|min:1|max:500',
            'search.value' => 'nullable|string|max:500',
            'order' => 'sometimes|array|max:9',
            'order.*.column' => 'required|integer|between:0,8',
            'order.*.dir' => 'required|in:asc,desc',
            'filtrosCabecera' => 'required|json',
        ]);
        $filtros = json_decode($request->input('filtrosCabecera'), true);
        validator(['filtros' => $filtros], [
            'filtros' => 'array',
            'filtros.*' => 'array',
            'filtros.*.incluir' => 'sometimes|array',
            'filtros.*.incluir.*' => 'string|max:500',
            'filtros.*.excluir' => 'sometimes|array',
            'filtros.*.excluir.*' => 'string|max:500',
        ])->validate();

        $columnas = $this->columnasTablaSSI();
        $base = $this->consultaTablaSSI();
        $total = (clone $base)->count();
        $consulta = clone $base;
        foreach ($filtros as $indice => $filtro) {
            if (!isset($columnas[$indice])) continue;
            $columna = DB::raw($columnas[$indice]);
            if (array_key_exists('incluir', $filtro)) {
                $consulta->whereIn($columna, $filtro['incluir']);
            }
            if (array_key_exists('excluir', $filtro)) {
                $consulta->whereNotIn($columna, $filtro['excluir']);
            }
        }
        $busqueda = trim($request->input('search.value', ''));
        if ($busqueda !== '') {
            // All terms must match; each term may occur in any searchable column.
            foreach (preg_split('/\s+/u', $busqueda) as $termino) {
                $consulta->where(function ($q) use ($columnas, $termino) {
                    foreach ($columnas as $columna) {
                        $q->orWhereRaw($columna.' LIKE ?', ['%'.$termino.'%']);
                    }
                });
            }
        }
        $filtrados = (clone $consulta)->count();
        foreach ($request->input('order', []) as $orden) {
            $consulta->orderByRaw($columnas[$orden['column']].' '.$orden['dir']);
        }
        $ids = $consulta->orderByDesc('ssi.id_servicio_de_ingenieria')
            ->offset((int) $request->input('start'))->limit((int) $request->input('length'))
            ->pluck('ssi.id_servicio_de_ingenieria');
        $modelos = Sol_servicio_de_ingenieria::with([
            'getSolicitud.getEmpleado',
            'getSolicitud.getEstadoSolicitud',
            'getSolicitud.getPrioridadSolicitud',
            'getSolicitud.getServicio.ultimaActualizacion.getActualizacion.getEstado',
            'getSector', 'getActivo',
        ])->whereIn('id_servicio_de_ingenieria', $ids)->get()->keyBy('id_servicio_de_ingenieria');
        $listaSSI = $ids->map(function ($id) use ($modelos) { return $modelos[$id]; });

        $usuario = $request->user();
        $permisos = [
            'esAdmin' => $usuario->hasRole('ADMIN'),
            'esTecnico' => $usuario->hasRole('TECNICO'),
            'esExterno' => $usuario->hasRole('EXTERNO'),
            'idEmpleado' => optional($usuario->getEmpleado)->id_empleado,
            'id_estado_aceptado' => config('myconfig.estado_solicitud_aceptado'),
        ];

        $datos = $listaSSI->map(function ($Ssi) use ($permisos) {
            $solicitud = $Ssi->getSolicitud;
            $descripcion = $solicitud->descripcion_solicitud ?? '';
            $estado = optional(optional(optional(optional($solicitud->getServicio)->ultimaActualizacion)->getActualizacion)->getEstado)->nombre_estado
                ?? optional($solicitud->getEstadoSolicitud)->nombre_estado_solicitud ?? '-';

            return [
                e(Carbon::parse($solicitud->fecha_carga)->format('Y-m-d')),
                e($solicitud->id_solicitud ?? '-'),
                e(optional($solicitud->getEmpleado)->nombre_empleado ?? '-'),
                e(optional($Ssi->getSector)->nombre_sector ?? '-'),
                '<abbr title="'.e($descripcion).'" style="text-decoration:none; font-variant:none;">'
                    .e(mb_substr($descripcion, 0, 100))
                    .(mb_strlen($descripcion) > 100 ? ' <i class="fas fa-eye"></i>' : '').'</abbr>',
                $solicitud->fecha_requerida === null ? 'Sin fecha' : e(Carbon::parse($solicitud->fecha_requerida)->format('Y-m-d')),
                e($estado),
                e(optional($solicitud->getPrioridadSolicitud)->nombre_prioridad_solicitud ?? '-'),
                e(optional($Ssi->getActivo)->codigo_activo ?? '-'),
                view('Ingenieria.Solicitud.SSI.acciones-tabla', array_merge($permisos, ['Ssi' => $Ssi]))->render(),
            ];
        });

        $respuesta = [
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtrados,
            'data' => $datos->values(),
        ];
        if ($request->boolean('opcionesFiltros')) {
            // Distinct values across the full table, independent of the current page.
            $respuesta['opcionesFiltros'] = [];
            foreach ($columnas as $indice => $columna) {
                $respuesta['opcionesFiltros'][$indice] = (clone $base)
                    ->selectRaw($columna.' AS valor')->distinct()->orderBy('valor')
                    ->get()->pluck('valor')->map(function ($valor) { return (string) $valor; })->values();
            }
        }
        return response()->json($respuesta);
    }

    private function consultaTablaSSI()
    {
        $ultimas = DB::table('actualizacion_servicio')
            ->select('id_servicio')->selectRaw('MAX(id_actualizacion_servicio) AS id_ultima')
            ->groupBy('id_servicio');

        return DB::table('sol_servicio_de_ingenieria as ssi')
            ->join('sol_solicitud as sol', 'sol.id_solicitud', '=', 'ssi.id_solicitud')
            ->leftJoin('empleado as emp', 'emp.id_empleado', '=', 'sol.id_empleado')
            ->leftJoin('sector as sec', 'sec.id_sector', '=', 'ssi.id_sector')
            ->leftJoin('activo as act', 'act.id_activo', '=', 'ssi.id_activo')
            ->leftJoin('sol_prioridad_solicitud as pri', 'pri.id_prioridad_solicitud', '=', 'sol.id_prioridad_solicitud')
            ->leftJoin('sol_estado_solicitud as esol', 'esol.id_estado_solicitud', '=', 'sol.id_estado_solicitud')
            ->leftJoinSub($ultimas, 'ultima', function ($join) {
                $join->on('ultima.id_servicio', '=', 'sol.id_servicio');
            })
            ->leftJoin('actualizacion_servicio as aserv', 'aserv.id_actualizacion_servicio', '=', 'ultima.id_ultima')
            ->leftJoin('actualizacion as actual', 'actual.id_actualizacion', '=', 'aserv.id_actualizacion')
            ->leftJoin('estado as est', 'est.id_estado', '=', 'actual.id_estado');
    }

    private function columnasTablaSSI()
    {
        // Only these expressions can be selected, filtered or ordered by the client.
        return [
            "DATE_FORMAT(sol.fecha_carga, '%Y-%m-%d')",
            'sol.id_solicitud',
            "COALESCE(emp.nombre_empleado, '-')",
            "COALESCE(sec.nombre_sector, '-')",
            "COALESCE(LEFT(sol.descripcion_solicitud, 100), '')",
            "COALESCE(DATE_FORMAT(sol.fecha_requerida, '%Y-%m-%d'), 'Sin fecha')",
            "COALESCE(est.nombre_estado, esol.nombre_estado_solicitud, '-')",
            "COALESCE(pri.nombre_prioridad_solicitud, '-')",
            "COALESCE(act.codigo_activo, '-')",
        ];
    }

    public function obtenerEmpleadosActivos(){
        return Empleado::orderBy('nombre_empleado')->activo()->get();
    }

    public function create()
    {
        return view('Informatica.GestionUsuarios.permisos.crear');
    }

    public function estadosParaSolicitud(){
        $estados_solicitud = Sol_estado_solicitud::orderBy('nombre_estado_solicitud')->get();
        $estados_servicio = Estado::orderBy('nombre_estado')->get();
        $array_estados = [];

        foreach ($estados_solicitud as $estado_solicitud) {
            array_push($array_estados, (object)[
                'nombre_estado_solicitud' => $estado_solicitud->nombre_estado_solicitud
            ]);
        }

        foreach ($estados_servicio as $estado_servicio) {
            array_push($array_estados, (object)[
                'nombre_estado_solicitud' => $estado_servicio->nombre_estado
            ]);
        }

        sort($array_estados);

        return $array_estados;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id_prioridad' => 'required',
            'descripcion' => 'required|string|max:500',
            'archivos.*' => 'file|max:2048' //Max size in kilobytes (2 MB)
        ],[
            'archivos.*.max' => 'El archivo es muy grande.'
        ]);

        $nombre = Auth::user()->getEmpleado->nombre_empleado;
        $descrip = $request->input('descripcion');
        $prioridad = $request->input('id_prioridad');
        $sintomas = $request->input('sintomas');


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

        if ($request->hasFile('archivos')) {
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
        }

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

        if (!empty($sintomas)) {
            foreach ($sintomas as $sintoma) {
                Sol_serv_ing_x_sintoma::create([
                    'id_sintoma' => $sintoma,
                    'id_servicio_de_ingenieria' => $Req_ing->id_servicio_de_ingenieria
                ]);
            }
        }
        
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
        }

        return redirect()->route('s_s_i.index')->with('mensaje', 'Solicitud de servicio de ingenieria creado con exito.');                    
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

    public function rechazar($id){
        $solicitud = Sol_solicitud::find($id);
        $solicitud->id_estado_solicitud = 3;
        $solicitud->save();

        try {
            $nombre = $solicitud->getEmpleado->nombre_empleado;
            $codigo = $solicitud->id_solicitud;
            $email = strval($solicitud->getEmpleado->email_empleado);
            Mail::to($email)->send(new SsiMailable($nombre, $codigo, 3));
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect()->route('s_s_i.index')->with('mensaje', 'Solicitud de servicio de ingenieria rechazada con exito.');  
    }

    public function destroy($id)
    {
                       
    }
}