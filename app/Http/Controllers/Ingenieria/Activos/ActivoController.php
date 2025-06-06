<?php

namespace App\Http\Controllers\Ingenieria\Activos;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Cambre\Activo;
use App\Models\Cambre\Servicio;
use App\Models\Cambre\Rol_empleado;
use App\Models\Cambre\Estado;
use App\Models\Cambre\Responsabilidad;
use App\Models\Cambre\Servicio_info;
use App\Models\Cambre\Actualizacion;
use App\Models\Cambre\Actualizacion_servicio;
use App\Models\Cambre\Etapa;
use App\Models\Cambre\Actualizacion_etapa;

class ActivoController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:VER-MENU-ACTIVOS', ['only' => ['index']]);
        //  $this->middleware('permission:CREAR-PERMISO', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-PERMISO', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-PERMISO', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {   
        $activos = Activo::orderBy('id_activo')->get();     
        return view('Ingenieria.Activos.index', compact('activos'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {         
        $this->validate($request, [
            'codigo_activo' => 'required',
            'nombre_activo' => 'required'
        ]);

        //variables
        $codigo =  strtoupper($request->input('codigo_activo'));
        $nombre = $request->input('nombre_activo');
        $descripcion = $request->input('descripcion');
        $nuevo_serv = $request->input('opt_nsa');
        $esta_activo = $request->input('esta_activo');
        //-----------------------------------

        //Crear activo
        $activo = Activo::create([
            'codigo_activo' => $codigo,
            'nombre_activo' => $nombre,
            'descripcion_activo' => $descripcion,
            'esta_activo' => $esta_activo
        ]);
        //------------------------------------

        if ($nuevo_serv) {
            $codigo_proyecto = strtoupper($activo->codigo_activo);
            $nombre_proyecto = $activo->codigo_activo;

            $fecha_ini = Carbon::now()->format('Y-m-d');
            $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');

            $prioridadMax = null;
            
            $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'lider')->first();

           
            $estado = Estado::where('nombre_estado', 'Continua')->first();

            $responsabilidad = Responsabilidad::create([
                'id_empleado' => 1,
                // 'id_empleado' => $lider,
                'id_rol_empleado' => $rol_empleado->id_rol_empleado
            ]);
            
            $proyecto = Servicio::create([
                'codigo_servicio' => $codigo_proyecto,
                'nombre_servicio' => $nombre_proyecto,
                'id_subtipo_servicio' => 7,
                'id_responsabilidad' => $responsabilidad->id_responsabilidad,
                'fecha_inicio' => $fecha_ini,
                'prioridad_servicio' => $prioridadMax,
                'id_activo' => $activo->id_activo
            ]);

            Servicio_info::create([
                'id_servicio' => $proyecto->id_servicio, 
                'tot_ord' => 0,
                'tot_ord_completa' => 0,
                'progreso' => 0
            ]);

            $rol_empleado_act = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();

            $responsabilidad_act = Responsabilidad::create([
                'id_empleado' => 1,
                'id_rol_empleado' => $rol_empleado_act->id_rol_empleado
            ]);

            $actualizacionServicio = Actualizacion::create([
                'descripcion' => 'Creacion de proyecto.',
                'fecha_limite' => null,
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
                'fecha_limite' => null,
                'fecha_carga' => $fecha_carga,
                'id_estado' => $estado->id_estado,
                'id_responsabilidad' => $responsabilidad->id_responsabilidad
            ]);

            $actualizacion_etapa = Actualizacion_etapa::create([
                'id_actualizacion' => $actualizacionEtapa->id_actualizacion,
                'id_etapa' => $etapa->id_etapa
            ]);
        }

        return redirect()->route('activos.index')->with('mensaje', 'Activo creado exitosamente.');             
    }
    
    public function show($id)
    {
    }
    
    public function edit($id)
    {
        $activo = Activo::find($id);
        return view('Ingenieria.Activos.editar', compact('activo'));
    }
    
    public function update(Request $request, $id)
    {             
        $this->validate($request, [
            'codigo_activo' => 'required',
            'nombre_activo' => 'required'
        ]);    
        
        //variables
        $nombre = $request->input('nombre_activo');
        $codigo =  strtoupper($request->input('codigo_activo'));
        $esta_activo = $request->input('esta_activo');
        //-----------------------------------

        $activo = Activo::find($id);

        $activo->update([
            'codigo_activo' => $codigo,
            'nombre_activo' => $nombre,
            'esta_activo' => $esta_activo
        ]);

        if ($request->input('descripcion')) {
            $activo->update([
                'descripcion_activo' => $request->input('descripcion')
            ]);
        }

        return redirect()->route('activos.index')->with('mensaje', 'Activo editado exitosamente.');           
    }
    
    public function destroy($id)
    {      
        Activo::destroy($id);

        return redirect()->route('activos.index')->with('mensaje', 'El activo se elimino exitosamente.');         
    }

}