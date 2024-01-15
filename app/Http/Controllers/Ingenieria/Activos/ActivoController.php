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
        //$this->middleware('auth');
        //  $this->middleware('permission:VER-PERMISO|CREAR-PERMISO|EDITAR-PERMISO|BORRAR-PERMISO', ['only' => ['index']]);
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
            'nombre_activo' => 'required'
        ]);

        //variables
        $nombre = $request->input('nombre_activo');
        $descripcion = $request->input('descripcion');
        //-----------------------------------

        //Crear activo
        Activo::create([
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
    }
    
    public function update(Request $request, $id)
    {                        
    }
    
    public function destroy($id)
    {            
    }

}