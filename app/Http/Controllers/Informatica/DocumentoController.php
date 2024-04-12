<?php

namespace App\Http\Controllers\Informatica;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Cambre\Empleado;
use App\Models\Cambre\Sector;
use App\Models\Cambre\Puesto_empleado;
use App\Models\Cambre\Doc_documento;


class DocumentoController extends Controller
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
        $documentos = Doc_documento::orderBy('nombre_documento')->get();
        return view('Informatica.Documentos.index', compact('documentos'));
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
            'nombre_documento' => 'required',
            'descripcion' => 'required',
            'archivo' => 'required|file'
        ]);

        $nombre = $request->input('nombre_documento');
        $descripcion = $request->input('descripcion');
        
        
        $filename = str_replace(" " ,"-", $nombre) . '.' . $request->file('archivo')->extension();
        $path = $request->file('archivo')->storeAs('', $filename, 'public_doc');
        
        Doc_documento::create([
            'nombre_documento' => $nombre,
            'descripcion_documento' => $descripcion,
            'ubicacion_documento' => 'storage/documentacion/'.$path
        ]);
      
        return redirect()->route('documentacion.index')->with('mensaje','El documento creado con exito.');                     
    }
    
    public function show($id)
    {
    }
    
    public function edit($id)
    {
        return "En desarrollo";
        $empleado = Empleado::find($id);
        $sectores = Sector::orderBy('nombre_sector')->pluck('nombre_sector', 'id_sector');
        $puestos = Puesto_empleado::orderBy('titulo_puesto_empleado')->pluck('titulo_puesto_empleado', 'id_puesto_empleado');
        return view('Informatica.Empleados.editar',compact('empleado', 'sectores', 'puestos'));
    }
    
    public function update(Request $request, $id)
    {
        return "En desarrollo";
        $this->validate($request, [
            'nombre_completo' => 'required',
            'email' => 'required',
            'puesto' => 'required',
            'sector' => 'required',
            'costo_hora' => 'required'
        ]);

        $nombre = $request->input('nombre_completo');
        $email = $request->input('email');
        $puesto = $request->input('puesto');
        $sector = $request->input('sector');
        $costo_hora = $request->input('costo_hora');

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
            'id_sector' => $sector,
            'costo_hora' => $costo_hora
        ]);
    
        return redirect()->route('tecnicos.index')->with('mensaje','El usuario '.$nombre.' editado exitosamente.');                        
    }
    
    public function destroy($id)
    {
        $archivo = Doc_documento::find($id);
        $parte_recortada = strrchr($archivo->ubicacion_documento, "/");
        $nombre_del_archivo = substr($parte_recortada, 1);
        if (Storage::disk('public_doc')->delete($nombre_del_archivo)) {
            Doc_documento::destroy($id);
            return redirect()->route('documentacion.index')->with('mensaje', 'El documento se elimino exitosamente.');
        }else{
            return redirect()->route('documentacion.index')->with('error', 'Ocurrio un error al borrar el archivo.');
        }               
    }

    public function rutaDelArchivo($nombreArchivo)
    {
        $ruta = Doc_documento::where('nombre_documento', 'like', '%'.$nombreArchivo.'%')->first()->ubicacion_documento;
        return $ruta;
    }
}