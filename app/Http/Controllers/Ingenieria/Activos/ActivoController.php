<?php

namespace App\Http\Controllers\Ingenieria\Activos;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Cambre\Activo;

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
        //-----------------------------------

        //Crear activo
        Activo::create([
            'codigo_activo' => $codigo,
            'nombre_activo' => $nombre,
            'descripcion_activo' => $descripcion
        ]);
        //------------------------------------
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
        //-----------------------------------

        $activo = Activo::find($id);

        $activo->update([
            'codigo_activo' => $codigo,
            'nombre_activo' => $nombre
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