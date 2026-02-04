<?php

namespace App\Http\Controllers\Ingenieria\Activos\Ishikawa;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Cambre\Ishikawa_categoria;

class IshikawaCategoriaController extends Controller
{
    public function index()
    {
        $categorias = Ishikawa_categoria::all();
        return view('Ingenieria.Activos.Ishikawa.Categoria.index', compact('categorias'));
    }

    public function store(Request $request){
       $this->validate($request, [
           'codigo_categoria' => 'required|string|max:50|unique:ishikawa_categoria,codigo_categoria',
           'nombre_categoria' => 'required|string|max:100',
       ]);
       $categoria = new Ishikawa_categoria();
       $categoria->codigo_categoria = $request->input('codigo_categoria');
       $categoria->nombre_categoria = $request->input('nombre_categoria');
       $categoria->save();
       return redirect()->route('ishikawa_categoria.index')->with('success', 'Categoría creada exitosamente.');
    }
    
    public function edit($id)
    {
        $categoria = Ishikawa_categoria::find($id);    
        return view('Ingenieria.Activos.Ishikawa.Categoria.edit', compact('categoria'));
    }

    public function update(Request $request, $id){
         $this->validate($request, [
              'codigo_categoria' => 'required|string|max:50|unique:ishikawa_categoria,codigo_categoria,'.$id.',id_ishikawa_categoria',
              'nombre_categoria' => 'required|string|max:100',
         ]);
         $categoria = Ishikawa_categoria::find($id);
         $categoria->codigo_categoria = $request->input('codigo_categoria');
         $categoria->nombre_categoria = $request->input('nombre_categoria');
         $categoria->save();
         return redirect()->route('ishikawa_categoria.index')->with('success', 'Categoría actualizada exitosamente.');       
    }   

    public function destroy($id){
       $categoria = Ishikawa_categoria::find($id);
       $categoria->delete();
       return redirect()->route('ishikawa_categoria.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}