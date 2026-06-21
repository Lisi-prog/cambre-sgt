<?php

namespace App\Http\Controllers\Ingenieria\Activos;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Cambre\Zona;
use App\Models\Cambre\Zona_x_tipo_activo;
use App\Models\Cambre\Tipo_activo;
use Illuminate\Support\Facades\DB;


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

    public function verAsignarTipo($id){
        $zona = Zona::findOrFail($id);
        $tipos = Tipo_activo::orderBy('nombre_tipo_activo')->get();
        return view('Ingenieria.Activos.Zona.asignar-tipo', compact('zona', 'tipos'));
    }

    public function asignarSubTipo(Request $request, $id){
        
        try {    
            DB::beginTransaction();

            if(empty($request->input('subtipo'))){
                //return 'llega vacio';

                $subTipoAnt = Zona_x_tipo_activo::where('id_zona', '=', $id)->get();
                
                foreach($subTipoAnt as $sta){
                    Zona_x_tipo_activo::where('id_zona', $id)->where('id_tipo_activo', $sta->id_tipo_activo)->first()->delete();
                }
    
            }else{
                //return 'llega con algo';
                $subTipoAnt = Zona_x_tipo_activo::where('id_zona', '=', $id)->get();
                
                foreach($subTipoAnt as $sta){
                    Zona_x_tipo_activo::where('id_zona', $id)->where('id_tipo_activo', $sta->id_tipo_activo)->delete();
                }

                $ids_subtipos = $request->input('subtipo');

                foreach ($ids_subtipos as $idst) {
                    Zona_x_tipo_activo::create([
                        'id_zona' => $id,
                        'id_tipo_activo' => $idst
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('zona.index')->with('mensaje', 'Se asignaron los tipo activo a la zona con éxito.');                      
    
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                             ->with('error', 'Ocurrio un problema al asignar los tipo activo a la zona: '.$e->getMessage());
        }
    }
}