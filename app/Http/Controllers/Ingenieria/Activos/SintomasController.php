<?php

namespace App\Http\Controllers\Ingenieria\Activos;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Cambre\Sintoma;
use App\Models\Cambre\Tipo_sintoma;
use App\Models\Cambre\Tipo_activo_x_sintoma;
use App\Models\Cambre\Sol_serv_man_x_sintoma;
use App\Models\Cambre\Activo_x_sintoma;

class SintomasController extends Controller
{
    public function index()
    {
        $sintomas = Sintoma::with('getTipoSintoma')->get();
        $tipos_sintomas = Tipo_sintoma::orderBy('nombre_tipo_sintoma', 'ASC')->get();        
        return view('Ingenieria.Activos.Sintomas.index', compact('sintomas', 'tipos_sintomas'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'nombre_sintoma' => 'required|string|max:150|unique:sintoma,nombre_sintoma',
            'tipo_sintoma' => 'required|exists:tipo_sintoma,id_tipo_sintoma',
        ]);
        try{
            $sintoma = new Sintoma();
            $sintoma->nombre_sintoma = $request->input('nombre_sintoma');
            $sintoma->id_tipo_sintoma = $request->input('tipo_sintoma');
            $sintoma->save();
            return redirect()->route('sintoma.index')->with('success', 'Síntoma creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el síntoma: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        //
    }   

    public function edit($id)
    {
        $sintoma = Sintoma::findOrFail($id);
        $tipos_sintomas = Tipo_sintoma::orderBy('nombre_tipo_sintoma', 'ASC')->get();  
        return view('Ingenieria.Activos.Sintomas.edit', compact('sintoma', 'tipos_sintomas'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'nombre_sintoma' => 'required|string|max:150|unique:sintoma,nombre_sintoma,'.$id.',id_sintoma',
            'tipo_sintoma' => 'required|exists:tipo_sintoma,id_tipo_sintoma',
        ]);
        try{   
            $sintoma = Sintoma::findOrFail($id); 
            $sintoma->nombre_sintoma = $request->input('nombre_sintoma');
            $sintoma->id_tipo_sintoma = $request->input('tipo_sintoma');
            $sintoma->save();
            return redirect()->route('sintoma.index')->with('success', 'Síntoma actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el síntoma: ' . $e->getMessage())->withInput();;
        }   
    }   

    public function destroy($id){
        try{
            $sintoma = Sintoma::findOrFail($id);  
            $sintoma->delete();
            return redirect()->route('sintoma.index')->with('success', 'Síntoma eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el síntoma: ' . $e->getMessage());
        }
    }
}