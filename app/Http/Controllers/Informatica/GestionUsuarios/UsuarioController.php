<?php

namespace App\Http\Controllers\Informatica\GestionUsuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
//agregamos 
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;


class UsuarioController extends Controller
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
        $usuarios = User::orderBy('name', 'asc')->get();
        return view('Informatica.GestionUsuarios.usuarios.index', compact('usuarios'));
    }
    
    public function create(Request $request)
    {
          
    }
    
    public function store(Request $request)
    {
                           
    }
    
    public function show($id)
    {
    }
    
    public function edit(Request $request, $id)
    {
        $user = Auth::user();
        $user = User::find($id);
        $userPermisos = $user->getDirectPermissions();
        $roles = Role::orderBy('name', 'asc')->get();
        $userRoles = $user->getRoleNames();
        // return $userRoles;
        return view('Informatica.GestionUsuarios.usuarios.editar',compact('user', 'roles', 'userPermisos', 'userRoles'));
    }
    
    public function update(Request $request, $id)
    {
        
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }

        $user = User::find($id);
        $user->update($input);

        $permisos = $request->input("permisos");
        $roles = $request->input("roles");

        try {
            $permisoAsig = Permission::whereIn('id', $permisos)->get();
        } catch (\Throwable $th) {
            $permisoAsig = [];
        }

        try {
            $rolesAsig = Role::whereIn('id', $roles)->get();
        } catch (\Throwable $th) {
            $rolesAsig = [];
        }

        $user->syncRoles($rolesAsig);
        $user->syncPermissions($permisoAsig);

        return redirect()->route('usuarios.index')->with('mensaje','El usuario '.$user->name. ' editado con éxito!.');                     
    }
    
    public function destroy($id)
    {   
        $user = User::findOrFail($id);
        User::destroy($id);

        return redirect()->route('usuarios.index')->with('mensaje','El usuario '.$user->name.' borrado con éxito!.');    
        
    }

    public function editarUsuario(Request $request){
        $this->validate($request, [
            'name' => 'required',
        ]);

        //return $request;
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->save();

        return redirect()->route('inicio')->with('mensaje','Perfil editado con éxito!.');                       
    }

    public function editarUsuarioPass(Request $request){
        // return $request;
        $request->validate([
            'password' => 'required||min:6|same:password_confirmation'
        ], [
            'password.min' => 'El campo contraseña debe tener al menos 6 caracteres.'
        ]);

        if (Hash::check($request->input('password_current'), Auth::user()->password)) {
            $user = Auth::user();
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return redirect()->route('inicio')->with('mensaje','Contraseña editada con éxito!.');                       
        } else {
            return redirect()->route('inicio')->with('error','La contraseña actual es incorrecta.'); 
        }                      
    }

    public function guardargrupo(Request $request)  
    {
        //return $request->input('idpadre').$request->input('nombre').'3';
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:roles,name',
            'idpadre' => 'required|min:0|max:9999|integer',
        ]);
        if ($validator->fails()) {
            return redirect()->route('roles.index')
                        ->withErrors($validator)
                        ->withInput();
        }
    
        $role = Role::create(['name' => strtoupper($name)]);
               
        return redirect()->route('roles.creargrupo')->with('mensaje','Grupo '.strtoupper($request->input('name')). ' creado con éxito!.');                       
    }
     
    public function buscarpermisos(Request $request)
    {
        
        $name = $request->input("name3");

        if ($name =='') {
            $permisos = Permission::orderBy('name', 'asc')->get();
        } else {
            $name = strtoupper($name);
            $permisos = Permission::where('name', 'like', '%'.$name.'%')->orderBy('name', 'asc')->get();
        }
        //Role::where('airline_id', '')->orderBy('name', 'asc')->paginate(5);
        return $permisos;

    }
    public function buscarrol(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric'
        ]);
        $id = $request->input("id");

        $rol = Role::find($id);

        return compact('rol');

    }
    
}