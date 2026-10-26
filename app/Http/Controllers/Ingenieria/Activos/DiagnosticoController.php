<?php

namespace App\Http\Controllers\Ingenieria\Activos;

use App\Http\Controllers\Controller;
use App\Models\Cambre\Diagnostico;
use App\Models\Cambre\Diagnostico_categoria;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DiagnosticoController extends Controller
{
    public function index()
    {
        $diagnosticos = Diagnostico::with('getCategoria')->get();
        $categorias = Diagnostico_categoria::orderBy('nombre_diagnostico_categoria')->get();

        return view('Ingenieria.Activos.Diagnostico.index', compact('diagnosticos', 'categorias'));
    }

    public function store(Request $request)
    {
        Diagnostico::create($this->datosValidados($request));

        return redirect()->route('diagnostico.index')->with('mensaje', 'Diagnóstico creado exitosamente.');
    }

    public function edit($id)
    {
        $diagnostico = Diagnostico::findOrFail($id);
        $categorias = Diagnostico_categoria::orderBy('nombre_diagnostico_categoria')->get();

        return view('Ingenieria.Activos.Diagnostico.edit', compact('diagnostico', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $diagnostico = Diagnostico::findOrFail($id);
        $diagnostico->update($this->datosValidados($request));

        return redirect()->route('diagnostico.index')->with('mensaje', 'Diagnóstico actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $diagnostico = Diagnostico::findOrFail($id);

        try {
            $diagnostico->delete();
        } catch (QueryException $e) {
            if ((int) ($e->errorInfo[1] ?? 0) !== 1451) {
                throw $e;
            }

            return redirect()->route('diagnostico.index')
                ->with('error', 'El diagnóstico está relacionado a un parte. Puede desmarcar En uso para desactivarlo.');
        }

        return redirect()->route('diagnostico.index')->with('mensaje', 'Diagnóstico eliminado exitosamente.');
    }

    private function datosValidados(Request $request)
    {
        $datos = $request->validate([
            'nombre_diagnostico' => 'required|string|max:100',
            'explicacion' => 'required|string|max:200',
            'id_diagnostico_categoria' => 'required|exists:diagnostico_categoria,id_diagnostico_categoria',
            'en_uso' => 'required|boolean',
        ]);

        $datos['nombre_diagnostico'] = mb_strtoupper($datos['nombre_diagnostico'], 'UTF-8');
        $datos['explicacion'] = mb_strtoupper($datos['explicacion'], 'UTF-8');

        return $datos;
    }
}
