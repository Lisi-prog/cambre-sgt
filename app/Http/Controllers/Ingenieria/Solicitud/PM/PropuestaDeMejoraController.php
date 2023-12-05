<?php

namespace App\Http\Controllers\Ingenieria\Solicitud\PM;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use App\Models\Cambre\Prioridad_solicitud;
use App\Models\Cambre\Estado_solicitud;
use App\Models\Cambre\Solicitud;
use App\Models\Cambre\Propuesta_de_mejora;
use App\Models\Cambre\Sector;
use App\Models\Cambre\Empleado;

class PropuestaDeMejoraController extends Controller
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
        //$permisos = Permission::orderBy('name', 'asc')->get();
        $ListaPM = Propuesta_de_mejora::get();
        return view('Ingenieria.Solicitud.PM.index', compact('ListaPM'));
    }

    public function crearAlt(Request $request)
    {        
        //$permisos = Permission::orderBy('name', 'asc')->get();
        $Prioridades = Prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->pluck('nombre_prioridad_solicitud', 'id_prioridad_solicitud');
        $Sectores = Sector::orderBy('nombre_sector', 'asc')->pluck('nombre_sector', 'id_sector');
        return view('Ingenieria.Solicitud.PM.CrearAlt', compact('Prioridades', 'Sectores'));
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
        $estado = Estado_solicitud::where('id_estado_solicitud', 1)->first()->id_estado_solicitud;
   
        
        $Solicitud = Solicitud::create([
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

        $Pro_mej = Propuesta_de_mejora::create([
            'id_solicitud' => $Solicitud->id_solicitud,
            'id_empleado' => 1,
            'id_sector' => $sector
        ]);

        //return $Solicitud;
        //$permisos = Permission::orderBy('name', 'asc')->get();
        //$Prioridades = Prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->get();
        return redirect()->route('p_m.index')->with('mensaje', 'Propuesta de mejora creada exitosamente.');
    }
    
    public function evaluar($id){
        $Req_ing = Requerimiento_de_ingenieria::find($id);
        $Empleados = Empleado::pluck('nombre_empleado', 'id_empleado');
        return view('Ingenieria.Solicitud.RI.Evaluar', compact('Req_ing', 'Empleados'));
    }

    public function buscarPermisos(Request $request)
    {        
         //Con paginación
         $permisos = Permission::get();
         return view('Coordinacion.Informatica.GestionUsuarios.permisos.index',compact('permisos'));
         //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!} 
    }

    public function create()
    {
        $Prioridades = Prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->pluck('nombre_prioridad_solicitud', 'id_prioridad_solicitud');
        return view('Ingenieria.Solicitud.PM.Crear', compact('Prioridades'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:189|unique:permissions,name'
        ], [
            'name.required' => 'El campo nombre del permiso es obligatorio.',
            'name.unique' => 'El permiso ya existe.',
            'name.max' => 'El maximo de caracteres es de 190.'
        ]);

        $permiso =  Permission::create([
                        'name' => strtoupper($request->input('name'))
                    ]); 

        $role = Role::where('name','ADMIN')->first();

        $role->givePermissionTo(strtoupper($request->input('name')));

        return redirect()->route('permisos.index')->with('mensaje', 'Permiso creado exitosamente.');                      
    }
    
    public function show($id)
    {
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

    public function buscarpermisospornombre($nombre){
        return Permission::where('name', 'like', '%'.$nombre.'%')->get();
    }
}