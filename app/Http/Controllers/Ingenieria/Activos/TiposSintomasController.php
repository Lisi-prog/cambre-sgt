<?php

namespace App\Http\Controllers\Ingenieria\Activos;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Cambre\Sintoma;
use App\Models\Cambre\Tipo_sintoma;

class TiposSintomasController extends Controller
{
    public function index()
    {
        $tipos_sintomas = Tipo_sintoma::orderBy('nombre_tipo_sintoma', 'ASC')->get();        
        return view('Ingenieria.Activos.Sintomas.TiposSintomas.index', compact('tipos_sintomas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_sintoma' => 'required|string|max:150|unique:tipo_sintoma,nombre_tipo_sintoma',
        ]);
        try{ 
            $tipo_sintoma = new Tipo_sintoma();
            $tipo_sintoma->nombre_tipo_sintoma = $request->input('tipo_sintoma');
            $tipo_sintoma->save();
            return redirect()->route('tipo_sintoma.index')->with('success', 'Tipo de síntoma creado exitosamente.');
        } 
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el tipo de síntoma: ' . $e->getMessage())->withInput();
        }
       
    }
    public function edit($id)
    {
        $tipo_sintoma = Tipo_sintoma::findOrFail($id);
        return view('Ingenieria.Activos.Sintomas.TiposSintomas.edit', compact('tipo_sintoma'));
    }
    
    public function update(Request $request, $id){
        $request->validate([
            'tipo_sintoma' => 'required|string|max:150|unique:tipo_sintoma,nombre_tipo_sintoma,'.$id.',id_tipo_sintoma',
        ]);
        try{   
            $tipo_sintoma = Tipo_sintoma::findOrFail($id); 
            $tipo_sintoma->nombre_tipo_sintoma = $request->input('tipo_sintoma');
            $tipo_sintoma->save();
            return redirect()->route('tipo_sintoma.index')->with('success', 'Tipo de síntoma actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el tipo de síntoma: ' . $e->getMessage())->withInput();;
        }   
    }

    public function destroy($id){
        $tipo_sintoma = Tipo_sintoma::findOrFail($id);  
        $tipo_sintoma->delete();
        return redirect()->route('tipo_sintoma.index')->with('success','Tipo de síntoma eliminado exitosamente.');
    }
}