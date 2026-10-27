<?php

namespace App\Http\Controllers\Ingenieria\Activos\Tarea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cambre\Tarea_mantenimiento;

class TareaMantenimientoController extends Controller
{
    public function index(){
        $tareas = Tarea_mantenimiento::all();
        return view('Ingenieria.Activos.Tarea.index', compact('tareas'));
    }

    public function store(Request $request){
        $request->validate([
            'nombre_tarea' => 'required|string|max:200',
            'en_uso' => 'sometimes|boolean',
        ]); 

        $tarea = new Tarea_mantenimiento();
        $tarea->nombre_tarea = $request->nombre_tarea;
        $tarea->en_uso = (int) $request->input('en_uso', 1);
        $tarea->save();

        if ($request->expectsJson()) {
            $filas = [];
            foreach (['correctiva', 'preventiva_activo', 'preventiva_tipo'] as $tipo) {
                $filas[$tipo] = view('Ingenieria.Activos.modal.fila-tarea-disponible', compact('tarea', 'tipo'))->render();
            }

            return response()->json(['tarea' => $tarea, 'filas' => $filas], 201);
        }

        return redirect()->route('tarea_mantenimiento.index')->with('success', 'Tarea creada exitosamente.');
    }

    public function edit($id)
    {
        $tarea = Tarea_mantenimiento::find($id);
        return view('Ingenieria.Activos.Tarea.edit', compact('tarea'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_tarea' => 'required|string|max:200',
            'en_uso' => 'required|boolean',
        ]);

        $tarea = Tarea_mantenimiento::find($id);
        $tarea->nombre_tarea = $request->nombre_tarea;
        $tarea->en_uso = (int) $request->input('en_uso');
        $tarea->save();

        return redirect()->route('tarea_mantenimiento.index')->with('success', 'Tarea actualizada exitosamente.');
    }

    public function destroy($id)
    {
        try {
            $tarea = Tarea_mantenimiento::find($id);
            $tarea->delete();
        } catch (\Exception $e) {
            return redirect()->route('tarea_mantenimiento.index')->with('error', 'La Tarea ya se encuentra relacionado con algun parte.');
        }
        
        return redirect()->route('tarea_mantenimiento.index')->with('mensaje', 'Tarea eliminada exitosamente.');
    }
}

