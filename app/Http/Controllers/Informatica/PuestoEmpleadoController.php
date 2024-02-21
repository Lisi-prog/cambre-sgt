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


class PuestoEmpleadoController extends Controller
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
        $puestos_empleados = Puesto_empleado::orderBy('titulo_puesto_empleado')->get();
        return view('Informatica.Puesto_empleado.index',compact('puestos_empleados'));
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

        $this->validate($request, [
            'nombre_puesto_empleado' => 'required',
            'costo_hora' => 'required'
        ]);

        $nombre_puesto = $request->input('nombre_puesto_empleado');
        $costo_hora = $request->input('costo_hora');
        
        $puesto_empleado = Puesto_empleado::create([
            'titulo_puesto_empleado' => $nombre_puesto,
            'costo_hora' => $costo_hora
        ]);

        return redirect()->route('puesto_tecnico.index')->with('mensaje', 'El puesto '.$puesto_empleado->titulo_puesto_empleado.' creado exitosamente.');                     
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
    
        return redirect()->route('tecnicos.index')->with('mensaje','El usuario '.$nombre.' editado exitosamente.');                        
    }

    public function updateOrden(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'nombre_puesto_empleado' => 'required',
            'costo_hora' => 'required',
            'id_puesto' => 'required'
        ]);

        $id_puesto = $request->input('id_puesto');
        $nombre_puesto = $request->input('nombre_puesto_empleado');
        $costo_hora = $request->input('costo_hora');
        
        $puesto_empleado = Puesto_empleado::find($id_puesto);

        $puesto_empleado->update([
            'titulo_puesto_empleado' => $nombre_puesto,
            'costo_hora' => $costo_hora
        ]);

        return redirect()->route('puesto_tecnico.index')->with('mensaje', 'El puesto '.$puesto_empleado->titulo_puesto_empleado.' editado exitosamente.');                      
    }
    
    public function destroy($id)
    {
        try {
            $puesto_empleado = Puesto_empleado::find($id);
            Puesto_empleado::destroy($id);
            return redirect()->route('puesto_tecnico.index')->with('mensaje', 'El puesto se elimino exitosamente.'); 
        } catch (\Throwable $th) {
            return redirect()->route('puesto_tecnico.index')->with('error', 'El puesto empleado esta asignado a un empleado.'); 
        }             
    }
}