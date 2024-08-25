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
use App\Models\Cambre\Sector;
use App\Models\Cambre\Activo;
use App\Models\Cambre\Empleado;
use App\Models\Cambre\Subtipo_servicio;
use App\Models\Cambre\Servicio;
use App\Models\Cambre\Prefijo_proyecto;
use App\Models\Cambre\Estado;
use App\Mail\Solicitud\SsiMailable;

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
        $listaSSI = Sol_servicio_de_ingenieria::orderBy('id_servicio_de_ingenieria', 'desc')->get();
        $Prioridades = Sol_prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->pluck('nombre_prioridad_solicitud', 'id_prioridad_solicitud');
        $activos = Activo::orderBy('codigo_activo')->whereNotNull('codigo_activo')->pluck('codigo_activo', 'id_activo');

        $flt_users = $this->obtenerEmpleadosActivos();
        $flt_sectores = Sector::orderBy('nombre_sector')->get();
        // $flt_estados = Sol_estado_solicitud::orderBy('nombre_estado_solicitud')->get();
        $flt_estados = $this->estadosParaSolicitud();
        $flt_prioridades = Sol_prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->get();
        
        return view('Ingenieria.Solicitud.SSI.index', compact('listaSSI', 'Prioridades', 'activos', 'flt_users', 'flt_sectores', 'flt_estados', 'flt_prioridades'));
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
            'archivos.*' => 'file|mimes:pdf,doc,docx'
        ],[
            'archivos.*.mimes' => 'El tipo de archivo solo puede ser un .pdf, .doc o .docx'
        ]);

        $nombre = Auth::user()->getEmpleado->nombre_empleado;
        $descrip = $request->input('descripcion');
        $prioridad = $request->input('id_prioridad');

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

        try {
            $nombre = $Solicitud->getEmpleado->nombre_empleado;
            $codigo = $Solicitud->id_solicitud;
            $email = strval(Auth::user()->getEmpleado->email_empleado);
            $email_aviso = explode(',', config('myconfig.ssi_email_admin'));
            Mail::to($email)->send(new SsiMailable($nombre, $codigo, 1));
            Mail::to($email_aviso)->send(new SsiMailable($nombre, $codigo, 4));
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
        $Tipos_servicios = Subtipo_servicio::orderByRaw('FIELD(id_subtipo_servicio, "1", "2", "4", "3", "5", "6")')->pluck('nombre_subtipo_servicio', 'id_subtipo_servicio');
        
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