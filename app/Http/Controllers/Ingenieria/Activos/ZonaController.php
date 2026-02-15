<?php

namespace App\Http\Controllers\Ingenieria\Activos;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Cambre\Zona;


class ZonaController extends Controller
{
    public function index()
    {
        $zonas = Zona::orderBy('nombre_zona', 'ASC')->get();        
        return view('Ingenieria.Activos.Zona.index', compact('zonas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'zona' => 'required|string|max:100|unique:zona,nombre_zona',
        ]);
        try{ 
            $zona = new Zona();
            $zona->nombre_zona = $request->input('zona');
            $zona->save();
            return redirect()->route('zona.index')->with('success', 'Zona creada exitosamente.');
        } 
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear zona: ' . $e->getMessage())->withInput();
        }
       
    }
    public function edit($id)
    {
        $zona = Zona::findOrFail($id);
        return view('Ingenieria.Activos.Zona.edit', compact('zona'));
    }
    
    public function update(Request $request, $id){
        $request->validate([
            'zona' => 'required|string|max:100|unique:zona,nombre_zona,'.$id.',id_zona',
        ]);
        try{   
            $zona = Zona::findOrFail($id); 
            $zona->nombre_zona = $request->input('zona');
            $zona->save();
            return redirect()->route('zona.index')->with('success', 'Zona actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar zona: ' . $e->getMessage())->withInput();;
        }   
    }

    public function destroy($id){
        $zona = Zona::findOrFail($id);  
        $zona->delete();
        return redirect()->route('zona.index')->with('success','Zona eliminada exitosamente.');
    }
}