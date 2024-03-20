<?php

namespace App\Http\Controllers\Ingenieria\Sector;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Cambre\Sector;

class SectorController extends Controller
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
        $sectores = Sector::orderBy('nombre_sector')->get();     
        return view('Ingenieria.Sector.index', compact('sectores'));      
    }

    public function create()
    {
    }

    public function store(Request $request)
    {  
        $this->validate($request, [
            'nombre_sector' => 'required'
        ]);

        //variables
        $nombre = $request->input('nombre_sector');
        //-----------------------------------

        //Crear activo
        Sector::create([
            'nombre_sector' => $nombre
        ]);
        //------------------------------------

        return redirect()->route('sectores.index')->with('mensaje', 'Sector creado exitosamente.');                     
    }
    
    public function show($id)
    {
    }
    
    public function edit($id)
    {
        $sector = Sector::find($id);
        return view('Ingenieria.Sector.editar', compact('sector'));
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre_sector' => 'required'
        ]);    
        
        //variables
        $nombre = $request->input('nombre_sector');
        //-----------------------------------

        $sector = Sector::find($id);

        $sector->update([
            'nombre_sector' => $nombre
        ]);

        return redirect()->route('sectores.index')->with('mensaje', 'Sector editado exitosamente.');                        
    }
    
    public function destroy($id)
    {      
        Sector::destroy($id);

        return redirect()->route('sectores.index')->with('mensaje', 'El sector se elimino exitosamente.');       
    }

}