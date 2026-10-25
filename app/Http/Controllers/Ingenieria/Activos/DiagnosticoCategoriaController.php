<?php

namespace App\Http\Controllers\Ingenieria\Activos;

use App\Http\Controllers\Controller;
use App\Models\Cambre\Diagnostico_categoria;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DiagnosticoCategoriaController extends Controller
{
    public function index()
    {
        $categorias = Diagnostico_categoria::orderBy('nombre_diagnostico_categoria')->get();

        return view('Ingenieria.Activos.Diagnostico.Categoria.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        Diagnostico_categoria::create($this->datosValidados($request));

        return redirect()->route('diagnostico_categoria.index')->with('mensaje', 'Categoría creada exitosamente.');
    }

    public function edit($id)
    {
        $categoria = Diagnostico_categoria::findOrFail($id);

        return view('Ingenieria.Activos.Diagnostico.Categoria.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $categoria = Diagnostico_categoria::findOrFail($id);
        $categoria->update($this->datosValidados($request));

        return redirect()->route('diagnostico_categoria.index')->with('mensaje', 'Categoría actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $categoria = Diagnostico_categoria::findOrFail($id);

        try {
            $categoria->delete();
        } catch (QueryException $e) {
            if ((int) ($e->errorInfo[1] ?? 0) !== 1451) {
                throw $e;
            }

            return redirect()->route('diagnostico_categoria.index')
                ->with('error', 'La categoría está relacionada con diagnósticos o tipos de activo y no puede eliminarse.');
        }

        return redirect()->route('diagnostico_categoria.index')->with('mensaje', 'Categoría eliminada exitosamente.');
    }

    private function datosValidados(Request $request)
    {
        $datos = $request->validate([
            'nombre_diagnostico_categoria' => 'required|string|max:100',
        ]);

        $datos['nombre_diagnostico_categoria'] = mb_strtoupper($datos['nombre_diagnostico_categoria'], 'UTF-8');

        return $datos;
    }
}
