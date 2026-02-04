<?php

namespace App\Http\Controllers\Ingenieria\Solicitud\SMA;
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

    public function sma_obtener_causas($id){
        $activo = Activo::findOrFail($id);

        $idsSintomas = Tipo_activo_x_sintoma::where(
            'id_tipo_activo',
            $activo->getTipoActivo->id_tipo_activo
        )->pluck('id_sintoma');

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
}