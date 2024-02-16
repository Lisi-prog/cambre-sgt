<?php

namespace App\Http\Controllers\Informatica\GestionUsuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
//agregamos 
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;


class RolController extends Controller
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

    public function index(Request $request)
    {  
        $roles = Role::orderBy('name', 'asc')->get();
        return view('Informatica.GestionUsuarios.roles.index', compact('roles'));
    }
    
    public function create(Request $request)
    {
        return view('Informatica.GestionUsuarios.roles.crear');     
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
    
        $role = Role::create(['name' => strtoupper($request->input('name'))]);
        
        return redirect()->route('roles.index')->with('mensaje','Rol '.strtoupper($request->input('name')). ' creado con éxito!.');                       
    }
    
    public function show($id)
    {
    }
    
    public function edit(Request $request, $id)
    {
        $rol = Role::find($id);
        return view('Informatica.GestionUsuarios.roles.editar',compact('rol'));
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
    
        $role = Role::find($id);
        $role->update([
            'name' => strtoupper($request->input('name')),
        ]);
    
        return redirect()->route('roles.index')->with('mensaje','Rol '.strtoupper($request->input('name')). ' editado con éxito!.');                       
    }
    
    public function destroy($id)
    {   
        $rol = Role::findOrFail($id);

        Role::destroy($id);
        return redirect()->route('roles.index')->with('mensaje','Rol'.$rol->name.' borrado con éxito!.');    
        
    }

    public function verPermisosxRol($id){
        $rol = Role::findOrFail($id);
        $permisos = Permission::orderBy('name', 'asc')->get();
        $permisosAsignados = $rol->permissions;

        $listaPermisos = array();
              
        foreach ($permisosAsignados as $permisoAsignado) { 
           array_push($listaPermisos, $permisoAsignado->id);
        }
        return view('Informatica.GestionUsuarios.roles.permisos', compact('rol', 'permisos', 'permisosAsignados', 'listaPermisos'));

    }

    public function guardarPermisosxRol(Request $request, $id){

        $rol = Role::find($id);
        $permisos = $request->input("permisos");
        try {
            $permisoAsig = Permission::whereIn('id', $permisos)->get();
        } catch (\Throwable $th) {
            $permisoAsig = [];
        }
        
        $rol->syncPermissions($permisoAsig);

        return redirect()->route('roles.index')->with('mensaje','Rol '.$rol->name.' editado los permisos con éxito!.'); 
    }

    public function buscarpermisosdelrol(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric'
        ]);
        
        $id = $request->input("id");


        $rol = Role::find($id);
        $permisos = $rol->permissions;
        
        //Role::where('airline_id', '')->orderBy('name', 'asc')->paginate(5);
        return $permisos;

    }
    
}