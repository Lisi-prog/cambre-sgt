<?php

namespace App\Http\Controllers\Ingenieria\Activos\Tarea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cambre\Zona_tarea;

class ZonaTareaController extends Controller
{
    public function index(){
        $zonas = Zona_tarea::all();
        return view('Ingenieria.Activos.Tarea.Zona.index', compact('zonas'));
    }

    public function store(Request $request){
        $request->validate([
            'nombre_zona' => 'required|string|max:200',
        ]); 

        $zona = new Zona_tarea();
        $zona->nombre_zona = strtoupper($request->nombre_zona);
        $zona->save();

        return redirect()->route('zona_tarea.index')->with('mensaje', 'Zona creada exitosamente.');
    }

    public function edit($id)
    {
        $zona = Zona_tarea::find($id);
        return view('Ingenieria.Activos.Tarea.Zona.edit', compact('zona'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_zona' => 'required|string|max:200',
        ]);

        $zona = Zona_tarea::find($id);
        $zona->nombre_zona = strtoupper($request->nombre_zona);
        $zona->save();

        return redirect()->route('zona_tarea.index')->with('mensaje', 'Zona actualizada exitosamente.');
    }

    public function destroy($id)
    {
        try {
            $zona = Zona_tarea::find($id);
            $zona->delete();
        } catch (\Exception $e) {
            return redirect()->route('zona_tarea.index')->with('error', 'La zona ya esta relacionada con una tarea de mantenimiento.');
        }
        
        return redirect()->route('zona_tarea.index')->with('mensaje', 'Zona eliminada exitosamente.');
    }
}

