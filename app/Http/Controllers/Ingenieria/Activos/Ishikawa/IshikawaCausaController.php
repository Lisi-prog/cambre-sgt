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
        $causa->nombre_causa = $request->input('nombre_causa');
        $causa->id_ishikawa_categoria = $request->input('ishikawa_categoria');
        $causa->explicacion = $request->input('explicacion_causa');
        $causa->save();
        return redirect()->route('ishikawa_causa.index')->with('success', 'Causa creada exitosamente.');
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
        $causa->nombre_causa = $request->input('nombre_causa');
        $causa->id_ishikawa_categoria = $request->input('ishikawa_categoria');
        $causa->explicacion = $request->input('explicacion_causa');
        $causa->save();
        return redirect()->route('ishikawa_causa.index')->with('success', 'Causa actualizada exitosamente.');
    }   

    public function destroy($id){
       $causa = Ishikawa_causa::find($id);
       $causa->delete();
       return redirect()->route('ishikawa_causa.index')->with('success', 'Causa eliminada exitosamente.');
    }
}