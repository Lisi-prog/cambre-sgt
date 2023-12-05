<?php

namespace App\Http\Controllers\Ingenieria\Solicitud\SSI;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use App\Models\Cambre\Prioridad_solicitud;
use App\Models\Cambre\Servicio_de_ingenieria;
use App\Models\Cambre\Sector;

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
        //$permisos = Permission::orderBy('name', 'asc')->get();
        $Solicitudes = Servicio_de_ingenieria::get();
        return view('Ingenieria.Solicitud.SSI.index', compact('Solicitudes'));
    }

    public function crearAlt(Request $request)
    {        
        //$permisos = Permission::orderBy('name', 'asc')->get();
        $Prioridades = Prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->pluck('nombre_prioridad_solicitud', 'id_prioridad_solicitud');
        $Sectores = Sector::orderBy('nombre_sector', 'asc')->pluck('nombre_sector', 'id_sector');
        return view('Ingenieria.Solicitud.SSI.CrearAlt', compact('Prioridades', 'Sectores'));
    }

    public function guardarAlt(Request $request)
    {        
        return $request;
        //$permisos = Permission::orderBy('name', 'asc')->get();
        $Prioridades = Prioridad_solicitud::orderBy('id_prioridad_solicitud', 'asc')->get();
        return view('Ingenieria.Solicitud.ServicioDeIngenieria.CrearAlt', compact('Prioridades'));
        return redirect()->route('permisos.index')->with('mensaje', 'Permiso creado exitosamente.');
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
        return view('Informatica.GestionUsuarios.permisos.crear');
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