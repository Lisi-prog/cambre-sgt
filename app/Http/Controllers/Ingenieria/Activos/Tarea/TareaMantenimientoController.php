<?php

namespace App\Http\Controllers\Ingenieria\Activos\Tarea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cambre\Tarea_mantenimiento;
use App\Models\Cambre\Zona_tarea;
use App\Models\Cambre\Tarea_ejecucion;

class TareaMantenimientoController extends Controller
{
    public function index(){
        $tareas = Tarea_mantenimiento::all();
        $zonas = Zona_tarea::all();
        $ejecuciones = Tarea_ejecucion::all();
        return view('Ingenieria.Activos.Tarea.index', compact('tareas', 'zonas', 'ejecuciones'));
    }

    public function store(Request $request){
        $request->validate([
            'nombre_tarea' => 'required|string|max:200',
        ]); 

        $tarea = new Tarea_mantenimiento();
        $tarea->nombre_tarea = $request->nombre_tarea;
        if($request->ejecucion_nueva){
            $ejecucion = new Tarea_ejecucion();
            $ejecucion->nombre_ejecucion = $request->ejecucion_nueva;
            $ejecucion->save();
            $tarea->id_ejecucion = $ejecucion->id_ejecucion;
        } else {
            $tarea->id_ejecucion = $request->id_ejecucion;
        }
        $tarea->id_zona_tarea = $request->id_zona_tarea;
        $tarea->save();

        return redirect()->route('tarea_mantenimiento.index')->with('success', 'Tarea creada exitosamente.');
    }

    public function edit($id)
    {
        $tarea = Tarea_mantenimiento::find($id);
        $zonas = Zona_tarea::all();
        $ejecuciones = Tarea_ejecucion::all();
        return view('Ingenieria.Activos.Tarea.edit', compact('tarea', 'zonas', 'ejecuciones'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_tarea' => 'required|string|max:200',
            'id_zona_tarea' => 'required|exists:zona_tarea,id_zona_tarea',
            'id_ejecucion' => 'nullable|exists:tarea_ejecucion,id_ejecucion',
        ]);

        $tarea = Tarea_mantenimiento::find($id);
        $tarea->nombre_tarea = $request->nombre_tarea;
        if($request->ejecucion_nueva){
            $ejecucion = new Tarea_ejecucion();
            $ejecucion->nombre_ejecucion = $request->ejecucion_nueva;
            $ejecucion->save();
            $tarea->id_ejecucion = $ejecucion->id_ejecucion;
        } else {
            $tarea->id_ejecucion = $request->id_ejecucion;
        }
        $tarea->id_zona_tarea = $request->id_zona_tarea;
        $tarea->save();

        return redirect()->route('tarea_mantenimiento.index')->with('success', 'Tarea actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $tarea = Tarea_mantenimiento::find($id);
        $tarea->delete();

        return redirect()->route('tarea_mantenimiento.index')->with('success', 'Tarea eliminada exitosamente.');
    }
}

