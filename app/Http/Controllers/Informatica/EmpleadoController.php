<?php

namespace App\Http\Controllers\Informatica;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use App\Models\User;
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
        $roles = Role::orderBy('name')->pluck('name', 'id');
        return view('Informatica.Empleados.crear',compact('sectores', 'puestos', 'roles'));
    }

    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'nombre_completo' => 'required',
            'email' => 'required',
            'puesto' => 'required',
            'sector' => 'required',
            'user_wb' => 'required'
        ]);

        $nombre = $request->input('nombre_completo');
        $email = $request->input('email');
        $puesto = $request->input('puesto');
        $sector = $request->input('sector');
        if ($request->input('telefono')) {
            $telefono = $request->input('telefono');
        }else{
            $telefono = null;
        }

        $opcion = $request->input('user_wb');
        switch ($opcion) {
            case 0:
                Empleado::create([
                    'nombre_empleado' => $nombre,
                    'email_empleado' => $email,
                    'telefono_empleado' => $telefono,
                    'id_puesto_empleado' => $puesto,
                    'id_sector' => $sector 
                ]);
                break;
            
            case 1:
                $this->validate($request, [
                    'password' => 'required',
                    'rol' => 'required'
                ]);

                $rol = $request->input('rol');

                $usuario = User::create([
                    'name' => $nombre,
                    'email' => $email,
                    'password' => Hash::make($request->input('password'))
                ]);

                $usuario->assignRole(Role::find($rol));

                Empleado::create([
                    'nombre_empleado' => $nombre,
                    'email_empleado' => $email,
                    'telefono_empleado' => $telefono,
                    'id_puesto_empleado' => $puesto,
                    'id_sector' => $sector,
                    'user_id' => $usuario->id
                ]);

                break;
        }
        return redirect()->route('empleados.index')->with('mensaje', 'Empleado creado exitosamente.');                     
    }
    
    public function show($id)
    {
    }
    
    public function edit($id)
    {
        $empleado = Empleado::find($id);
        $sectores = Sector::orderBy('nombre_sector')->pluck('nombre_sector', 'id_sector');
        $puestos = Puesto_empleado::orderBy('titulo_puesto_empleado')->pluck('titulo_puesto_empleado', 'id_puesto_empleado');
        return view('Informatica.Empleados.editar',compact('empleado', 'sectores', 'puestos'));
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre_completo' => 'required',
            'email' => 'required',
            'puesto' => 'required',
            'sector' => 'required'
        ]);

        $nombre = $request->input('nombre_completo');
        $email = $request->input('email');
        $puesto = $request->input('puesto');
        $sector = $request->input('sector');
        if ($request->input('telefono')) {
            $telefono = $request->input('telefono');
        }else{
            $telefono = null;
        }
        $empleado = Empleado::find($id);

        $empleado->update([
            'nombre_empleado' => $nombre,
            'email_empleado' => $email,
            'telefono_empleado' => $telefono,
            'id_puesto_empleado' => $puesto,
            'id_sector' => $sector
        ]);
    
        return redirect()->route('empleados.index')->with('mensaje','El usuario '.$nombre.' editado exitosamente.');                        
    }
    
    public function destroy($id)
    {
        $empleado = Empleado::find($id);
        Empleado::destroy($id);
        User::destroy($empleado->user_id);
        return redirect()->route('empleados.index')->with('mensaje', 'El empleado se elimino exitosamente.');               
    }

    public function buscarpermisospornombre($nombre){
        return Permission::where('name', 'like', '%'.$nombre.'%')->get();
    }
}