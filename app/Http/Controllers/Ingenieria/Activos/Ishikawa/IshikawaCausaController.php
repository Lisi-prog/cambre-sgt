<?php

namespace App\Http\Controllers\Ingenieria\Activos\Ishikawa;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Cambre\Ishikawa_causa;
use App\Models\Cambre\Ishikawa_categoria;

class IshikawaCausaController extends Controller
{
    public function index()
    {
        $causas = Ishikawa_causa::all();
        $categorias = Ishikawa_categoria::all();
        return view('Ingenieria.Activos.Ishikawa.Causa.index', compact('causas', 'categorias'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'nombre_causa' => 'required|string|max:100',
            'ishikawa_categoria' => 'required|exists:ishikawa_categoria,id_ishikawa_categoria',
            'explicacion_causa' => 'required|string|max:200',
        ]);
        $causa = new Ishikawa_causa();
        $causa->nombre_causa = strtoupper($request->input('nombre_causa'));
        $causa->id_ishikawa_categoria = $request->input('ishikawa_categoria');
        $causa->explicacion = strtoupper($request->input('explicacion_causa'));
        $causa->save();
        return redirect()->route('ishikawa_causa.index')->with('mensaje', 'Causa creada exitosamente.');
    }
    
    public function edit($id)
    {
        $causa = Ishikawa_causa::find($id);
        $categorias = Ishikawa_categoria::all();
        return view('Ingenieria.Activos.Ishikawa.Causa.edit', compact('causa', 'categorias'));    
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'nombre_causa' => 'required|string|max:100',
            'ishikawa_categoria' => 'required|exists:ishikawa_categoria,id_ishikawa_categoria',
            'explicacion_causa' => 'nullable|string|max:200',
        ]);
        $causa = Ishikawa_causa::find($id);
        $causa->nombre_causa = strtoupper($request->input('nombre_causa'));
        $causa->id_ishikawa_categoria = $request->input('ishikawa_categoria');
        $causa->explicacion = strtoupper($request->input('explicacion_causa'));
        $causa->save();
        return redirect()->route('ishikawa_causa.index')->with('mensaje', 'Causa actualizada exitosamente.');
    }   

    public function destroy($id){
        try {
            $causa = Ishikawa_causa::find($id);
            $causa->delete();
        } catch (\Exception $e) {
            return redirect()->route('ishikawa_causa.index')->with('error', 'El diagnóstico ya se encuentra relacionado a un parte.');
        }
        return redirect()->route('ishikawa_causa.index')->with('mensaje', 'Diagnóstico eliminado exitosamente.');
    }
}