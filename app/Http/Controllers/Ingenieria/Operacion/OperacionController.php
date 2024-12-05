<?php

namespace App\Http\Controllers\Ingenieria\Operacion;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Cambre\Operacion;

class OperacionController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permission:VER-MENU-OPERACION', ['only' => ['index']]);
        //  $this->middleware('permission:CREAR-PERMISO', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-PERMISO', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-PERMISO', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {   
        $operaciones = Operacion::orderBy('nombre_operacion')->get();     
        return view('Ingenieria.Operacion.index', compact('operaciones'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {         
        $this->validate($request, [
            'nom_ope' => 'required',
        ]);

        //variables
        $nom =  strtoupper($request->input('nom_ope'));
        //-----------------------------------

        //Crear activo
        Operacion::create([
            'nombre_operacion' => $nom,
        ]);
        //------------------------------------

        return redirect()->route('operacion.index')->with('mensaje', 'Operacion creado exitosamente.');             
    }
    
    public function show($id)
    {
    }
    
    public function edit($id)
    {
        $op = Operacion::find($id);
        return view('Ingenieria.Operacion.edit', compact('op'));
    }
    
    public function update(Request $request, $id)
    {             
        $this->validate($request, [
            'nom_ope' => 'required'
        ]);    
        
        //variables
        $nom =  strtoupper($request->input('nom_ope'));
        //-----------------------------------

        $op = Operacion::find($id);

        $op->update([
            'nombre_operacion' => $nom
        ]);

        return redirect()->route('operacion.index')->with('mensaje', 'Operacion editado exitosamente.');           
    }
    
    public function destroy($id)
    {      
        Operacion::destroy($id);

        return redirect()->route('operacion.index')->with('mensaje', 'La operacion se elimino exitosamente.');         
    }

}