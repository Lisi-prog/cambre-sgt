<?php

namespace App\Http\Controllers\Ingenieria\Solicitud\RI;
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
use App\Models\Cambre\Subtipo_servicio;
use App\Models\Cambre\Activo;
use App\Models\Cambre\Prefijo_proyecto;

class RequerimientoDeIngenieriaController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        //  $this->middleware('permission:VER-PERMISO|CREAR-PERMISO|EDITAR-PERMISO|BORRAR-PERMISO', ['only' => ['index']]);
        //  $this->middleware('permission:CREAR-PERMISO', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-PERMISO', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-PERMISO', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {        
        //$permisos = Permission::orderBy('name', 'asc')->get();

        $Prioridades = Sol_prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->pluck('nombre_prioridad_solicitud', 'id_prioridad_solicitud');
        return view('Ingenieria.Solicitud.RI.index', compact('Prioridades'));
    }

    public function datos(Request $request)
    {
        $request->validate([
            'draw' => 'required|integer|min:0',
            'start' => 'required|integer|min:0',
            'length' => 'required|integer|min:1|max:500',
            'search.value' => 'nullable|string|max:500',
            'order' => 'sometimes|array|max:9',
            'order.*.column' => 'required|integer|between:0,7',
            'order.*.dir' => 'required|in:asc,desc',
            'filtrosCabecera' => 'required|json',
        ]);
        $filtros = json_decode($request->input('filtrosCabecera'), true);
        validator(['filtros' => $filtros], [
            'filtros' => 'array',
            'filtros.*' => 'array',
            'filtros.*.incluir' => 'sometimes|array',
            'filtros.*.incluir.*' => 'string',
            'filtros.*.excluir' => 'sometimes|array',
            'filtros.*.excluir.*' => 'string',
        ])->validate();

        $columnas = $this->columnasTablaRI();
        $base = $this->consultaTablaRI();
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
        $ids = $consulta->orderByDesc('ri.id_requerimiento_de_ingenieria')
            ->offset((int) $request->input('start'))->limit((int) $request->input('length'))
            ->pluck('ri.id_requerimiento_de_ingenieria');
        $modelos = Sol_requerimiento_de_ingenieria::with([
            'getSolicitud.getEmpleado', 'getSolicitud.getEstadoSolicitud',
            'getSolicitud.getPrioridadSolicitud', 'getSector',
        ])->whereIn('id_requerimiento_de_ingenieria', $ids)->get()->keyBy('id_requerimiento_de_ingenieria');
        $listaRI = $ids->map(function ($id) use ($modelos) { return $modelos[$id]; });

        $permisos = ['id_estado_aceptado' => config('myconfig.estado_solicitud_aceptado')];

        $datos = $listaRI->map(function ($Ri) use ($permisos) {
            $solicitud = $Ri->getSolicitud;
            return [
                e(Carbon::parse($solicitud->fecha_carga)->format('Y-m-d')),
                e($solicitud->id_solicitud ?? '-'),
                e(optional($solicitud->getEmpleado)->nombre_empleado ?? '-'),
                e(optional($Ri->getSector)->nombre_sector ?? '-'),
                e($solicitud->descripcion_solicitud ?? '-'),
                $solicitud->fecha_requerida === null ? 'Sin fecha' : e(Carbon::parse($solicitud->fecha_requerida)->format('Y-m-d')),
                e(optional($solicitud->getEstadoSolicitud)->nombre_estado_solicitud ?? '-'),
                e(optional($solicitud->getPrioridadSolicitud)->nombre_prioridad_solicitud ?? '-'),
                view('Ingenieria.Solicitud.RI.acciones-tabla', array_merge($permisos, ['Ri' => $Ri]))->render(),
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

    private function consultaTablaRI()
    {
        return DB::table('sol_requerimiento_de_ingenieria as ri')
            ->join('sol_solicitud as sol', 'sol.id_solicitud', '=', 'ri.id_solicitud')
            ->leftJoin('empleado as emp', 'emp.id_empleado', '=', 'sol.id_empleado')
            ->leftJoin('sector as sec', 'sec.id_sector', '=', 'ri.id_sector')
            ->leftJoin('sol_prioridad_solicitud as pri', 'pri.id_prioridad_solicitud', '=', 'sol.id_prioridad_solicitud')
            ->leftJoin('sol_estado_solicitud as est', 'est.id_estado_solicitud', '=', 'sol.id_estado_solicitud');
    }

    private function columnasTablaRI()
    {
        return [
            "DATE_FORMAT(sol.fecha_carga, '%Y-%m-%d')", 'sol.id_solicitud',
            "COALESCE(emp.nombre_empleado, '-')", "COALESCE(sec.nombre_sector, '-')",
            "COALESCE(sol.descripcion_solicitud, '-')",
            "COALESCE(DATE_FORMAT(sol.fecha_requerida, '%Y-%m-%d'), 'Sin fecha')",
            "COALESCE(est.nombre_estado_solicitud, '-')", "COALESCE(pri.nombre_prioridad_solicitud, '-')",
        ];
    }

    public function crearAlt(Request $request)
    {        
        //$permisos = Permission::orderBy('name', 'asc')->get();
        $Prioridades = Prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->pluck('nombre_prioridad_solicitud', 'id_prioridad_solicitud');
        $Sectores = Sector::orderBy('nombre_sector', 'asc')->pluck('nombre_sector', 'id_sector');
        return view('Ingenieria.Solicitud.RI.CrearAlt', compact('Prioridades', 'Sectores'));
    }

    public function guardarAlt(Request $request)
    {        
        $this->validate($request, [
            'nombre_completo' => 'required',
            'id_sector' => 'required',
            'descripcion' => 'required',
            'fecha_req' => 'required',
            'id_prioridad' => 'required'
        ]);
        
        $nombre = $request->input('nombre_completo');
        $descrip = $request->input('descripcion');
        $sector = $request->input('id_sector');
        $prioridad = $request->input('id_prioridad');
        $fecha_requerida = Carbon::parse($request->input('fecha_req'))->format('Y-m-d');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        $estado = Sol_estado_solicitud::where('id_estado_solicitud', 1)->first()->id_estado_solicitud;
   
        
        $Solicitud = Sol_solicitud::create([
            'id_prioridad_solicitud' => $prioridad,
            'id_estado_solicitud' => $estado,
            'nombre_solicitante' => $nombre,
            'descripcion_solicitud' => $descrip,
            'fecha_carga' => $fecha_carga,
            'fecha_requerida' => $fecha_requerida
        ]);

        if($request->input('descripcion_urgencia')){
            $Solicitud->update([
                'descripcion_urgencia' => $request->input('descripcion_urgencia')
            ]);
        }

        $Req_ing = Sol_requerimiento_de_ingenieria::create([
            'id_solicitud' => $Solicitud->id_solicitud,
            'id_empleado' => 1,
            'id_sector' => $sector
        ]);

        return redirect()->back()->with('mensaje','Se creo el requerimiento de ingenieria con exito.');
        //return $Solicitud;
        //$permisos = Permission::orderBy('name', 'asc')->get();
        //$Prioridades = Prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->get();
        return 'Creado con exito!';
        return view('Ingenieria.Solicitud.ServicioDeIngenieria.CrearAlt', compact('Prioridades'));
        return redirect()->route('permisos.index')->with('mensaje', 'Permiso creado exitosamente.');
    }
    
    public function evaluar($id){
        $Req_ing = Sol_requerimiento_de_ingenieria::find($id);
        $Tipos_servicios = Subtipo_servicio::orderByRaw('FIELD(id_subtipo_servicio, "1", "2", "4", "3", "5", "6")')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        
        $supervisores_user = User::role('SUPERVISOR')->get();

        foreach ($supervisores_user as $supervisor_user) {
            $id_supervisor[] = $supervisor_user->id;
        }

        $empleados = $this->obtenerSupervisoresAdmin();
        $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        $prefijos = Prefijo_proyecto::orderBy('nombre_prefijo_proyecto')->pluck('nombre_prefijo_proyecto', 'id_prefijo_proyecto');
        $activos = Activo::orderBy('codigo_activo')->whereNotNull('codigo_activo')->pluck('codigo_activo', 'id_activo');
        return view('Ingenieria.Solicitud.RI.Evaluar', compact('Req_ing', 'Tipos_servicios', 'empleados', 'prioridadMax', 'activos', 'prefijos'));
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

    public function aceptar(Request $request, $id){

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


        $codigo_proyecto = $request->input('codigo_proyecto');
        $nombre_proyecto = $request->input('nombre_proyecto');
        $tipo_proyecto = $request->input('id_tipo_proyecto');
        $lider = $request->input('lider');
        $fecha_ini = Carbon::parse($request->input('fecha_ini'))->format('Y-m-d');
        $fecha_req = Carbon::parse($request->input('fecha_req'))->format('Y-m-d');
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        $prioridadMax = Servicio::max('prioridad_servicio') + 1;
        $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'lider')->first();
        $estado = Estado::where('nombre_estado', 'espera')->first();
        
        $tipo_servicio = $request->input('id_tipo_proyecto');

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
            'prioridad_servicio' => $prioridadMax
        ]);

        $actualizacionServicio = Actualizacion::create([
            'descripcion' => 'Creacion de proyecto.',
            'fecha_limite' => $fecha_req,
            'fecha_carga' => $fecha_carga,
            'id_estado' => $estado->id_estado,
            'id_responsabilidad' => $responsabilidad->id_responsabilidad
        ]);

        $actualizacion_servicio = Actualizacion_servicio::create([
            'id_actualizacion' => $actualizacionServicio->id_actualizacion,
            'id_servicio' => $proyecto->id_servicio
        ]);

        $etapa = Etapa::create([
            'descripcion_etapa' => 'Creacion de etapa.',
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

        return $this->index();
    }

    public function rechazar($id){
        $solicitud = Sol_solicitud::find($id);
        $solicitud->id_estado_solicitud = 3;
        $solicitud->save();
        return redirect()->route('r_i.index')->with('mensaje', 'Solicitud de requerimiento de ingenieria rechazada con exito.');  
    }

    public function create()
    {
        $Prioridades = Prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->pluck('nombre_prioridad_solicitud', 'id_prioridad_solicitud');
        return view('Ingenieria.Solicitud.RI.Crear', compact('Prioridades'));
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
            $fecha_requerida = Carbon::parse($request->input('fecha_req'))->format('Y-m-d');
        }else{
            $fecha_requerida = null;
        }
        
        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');
        $estado = Sol_estado_solicitud::where('id_estado_solicitud', 1)->first()->id_estado_solicitud;
   
        
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

        $Req_ing = Sol_requerimiento_de_ingenieria::create([
            'id_solicitud' => $Solicitud->id_solicitud,
            'id_empleado' => Auth::user()->getEmpleado->id_empleado,
            'id_sector' => Auth::user()->getEmpleado->getSector->id_sector
        ]);

        return redirect()->route('r_i.index')->with('mensaje', 'Solicitud de requerimiento de ingenieria creado con exito.');                      
    }
    
    public function show($id)
    {
        $Req_ing = Sol_requerimiento_de_ingenieria::find($id);
        return view('Ingenieria.Solicitud.RI.show', compact('Req_ing'));
    }
    
    public function edit($id)
    {
        $Req_ing = Sol_requerimiento_de_ingenieria::find($id);
    
        return view('Ingenieria.Solicitud.RI.editar', compact('Req_ing'));
    }
    
    public function update(Request $request, $id)
    {
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
    
        return redirect()->route('r_i.index')->with('mensaje', 'Requerimiento de ingenieria editado exitosamente.');                        
    }
    
    public function destroy($id)
    {
        $permiso = Permission::findOrFail($id);

        Permission::destroy($id);

        return redirect()->route('permisos.index')->with('mensaje', 'El permiso se elimino exitosamente.');               
    }
}