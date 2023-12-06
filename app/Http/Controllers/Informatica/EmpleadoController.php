<?php

namespace App\Http\Controllers\Informatica;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;

use App\Models\Cambre\Empleado;
use App\Models\Cambre\Sector;
use App\Models\Cambre\Puesto_empleado;


class EmpleadoController extends Controller
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
        $empleados = Empleado::orderBy('id_empleado')->get();
        return view('Informatica.Empleados.index',compact('empleados'));
    }

    public function create()
    {
        $sectores = Sector::orderBy('nombre_sector')->pluck('nombre_sector', 'id_sector');
        $puestos = Puesto_empleado::orderBy('titulo_puesto_empleado')->pluck('titulo_puesto_empleado', 'id_puesto_empleado');
        return view('Informatica.Empleados.crear',compact('sectores', 'puestos'));
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