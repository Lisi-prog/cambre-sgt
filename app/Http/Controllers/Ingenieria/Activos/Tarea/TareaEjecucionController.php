<?php

namespace App\Http\Controllers\Ingenieria\Activos\Tarea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cambre\Tarea_ejecucion;

class TareaEjecucionController extends Controller
{
    public function index(){
        $ejecuciones = Tarea_ejecucion::all();
        return view('Ingenieria.Activos.Tarea.Ejecucion.index', compact('ejecuciones'));
    }

    public function store(Request $request){
        $request->validate([
            'nombre_ejecucion' => 'required|string|max:200',
        ]);

        $ejecucion = new Tarea_ejecucion();
        $ejecucion->nombre_ejecucion = $request->nombre_ejecucion;
        $ejecucion->save();

        return redirect()->route('tarea_ejecucion.index')->with('success', 'Ejecución creada exitosamente.');
    }

    public function edit($id)
    {
        $ejecucion = Tarea_ejecucion::find($id);
        return view('Ingenieria.Activos.Tarea.Ejecucion.edit', compact('ejecucion'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_ejecucion' => 'required|string|max:200',
        ]);

        $ejecucion = Tarea_ejecucion::find($id);
        $ejecucion->nombre_ejecucion = $request->nombre_ejecucion;
        $ejecucion->save();

        return redirect()->route('tarea_ejecucion.index')->with('success', 'Ejecución actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $ejecucion = Tarea_ejecucion::find($id);
        $ejecucion->delete();

        return redirect()->route('tarea_ejecucion.index')->with('success', 'Ejecución eliminada exitosamente.');
    }
}

