<?php

namespace App\Http\Controllers\Informatica\GestionUsuarios;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermisoController extends Controller
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
        $permisos = Permission::orderBy('name', 'asc')->get();
        return view('Informatica.GestionUsuarios.permisos.index',compact('permisos'));
        return 'hola';
        $name = $request->query->get('name');

        if ($name =='') {
            //Con paginación
            $permisos = Permission::orderBy('name', 'asc')->get();
            return view('Informatica.gestionUsuarios.permisos.index',compact('permisos'));
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            
            $name = strtoupper($name);
            $permisos = Permission::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->get();
            
            //$permisos = Permission::whereRaw('UPPER(name) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('name', 'asc')->simplePaginate(10); 
            return view('Coordinacion.Informatica.GestionUsuarios.permisos.index',compact('permisos'));
        }
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
}