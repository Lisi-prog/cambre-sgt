<?php

namespace App\Http\Controllers\Ingenieria\Maquinaria;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Cambre\Sector;
use App\Models\Cambre\Maquinaria;
use App\Models\Cambre\Operacion;
use App\Models\Cambre\Tipo_maquinaria;
use App\Models\Cambre\Ope_x_maq;

class MaquinariaController extends Controller
{
    function __construct()
    {
        //$this->middleware('auth');
        //  $this->middleware('permission:VER-PERMISO|CREAR-PERMISO|EDITAR-PERMISO|BORRAR-PERMISO', ['only' => ['index']]);
        //  $this->middleware('permission:CREAR-PERMISO', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-PERMISO', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-PERMISO', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {        
        $sectores = Sector::orderBy('nombre_sector')->pluck('nombre_sector', 'id_sector');
        $maquinarias = Maquinaria::orderBy('id_maquinaria')->get();
        $tipos = Tipo_maquinaria::orderBy('tipo_maquinaria')->pluck('tipo_maquinaria', 'id_tipo_maquinaria');
        return view('Ingenieria.Maquinaria.index', compact('sectores', 'maquinarias', 'tipos'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {            
        $this->validate($request, [
            'codigo_maquinaria' => 'required',
            'alias_maquinaria' => 'required'
        ]);

        //variables
        $alias = $request->input('alias_maquinaria');
        $codigo = $request->input('codigo_maquinaria');
        $descripcion = $request->input('descripcion');
        $sector = $request->input('id_sector');
        //-----------------------------------

        //Crear maquinaria
        Maquinaria::create([
            'codigo_maquinaria' => $codigo,
            'alias_maquinaria' => $alias,
            'descripcion_maquinaria' => $descripcion,
            'id_sector' => $sector
        ]);
        //------------------------------------
        return redirect()->route('maquinarias.index')->with('mensaje', 'Maquinaria codigo '.$codigo.' creado exitosamente.'); 
    }
    
    public function show($id)
    {
    }
    
    public function edit($id)
    {
        $maquinaria = Maquinaria::find($id);
        $sectores = Sector::orderBy('nombre_sector')->pluck('nombre_sector', 'id_sector');
        return view('Ingenieria.Maquinaria.editar', compact('maquinaria', 'sectores'));
    }
    
    public function update(Request $request, $id)
    {        
        $this->validate($request, [
            'codigo_maquinaria' => 'required',
            'alias_maquinaria' => 'required'
        ]);      
        
        //variables
        $alias = $request->input('alias_maquinaria');
        $codigo = $request->input('codigo_maquinaria');
        $descripcion = $request->input('descripcion');
        $sector = $request->input('id_sector');
        //-----------------------------------

        $maquinaria = Maquinaria::find($id);

        $maquinaria->update([
            'codigo_maquinaria' => $codigo,
            'alias_maquinaria' => $alias,
            'descripcion_maquinaria' => $descripcion,
            'id_sector' => $sector
        ]);
        return redirect()->route('maquinarias.index')->with('mensaje', 'Maquinaria editada exitosamente.'); 
    }
    
    public function destroy($id)
    {
        Maquinaria::destroy($id);

        return redirect()->route('maquinarias.index')->with('mensaje', 'La maquinaria se elimino exitosamente.');       
    }

    public function obtenerMaquinaria($id)
    {
        return Maquinaria::find($id);
    }

    public function obtenerMaquinarias()
    {
        return Maquinaria::orderBy('codigo_maquinaria')->get();
    }

    public function tipo_maquinaria_index(){
        $tipos_maq = Tipo_maquinaria::orderBy('tipo_maquinaria')->get();
        return view('Ingenieria.Maquinaria.Tipo_maquinaria.index', compact('tipos_maq'));
    }

    public function tipo_maquinaria_store(Request $request){
        $tipo = $request->input('tipo_maquinaria');

        Tipo_maquinaria::create([
            'tipo_maquinaria' => $tipo
        ]);

        return redirect()->route('tipo_maquinaria.index')->with('mensaje', 'El tipo maquinaria creado exitosamente.');
    }

    public function tipo_maquinaria_edit($id){
        $tip_maq = Tipo_maquinaria::find($id);
        return view('Ingenieria.Maquinaria.Tipo_maquinaria.edit', compact('tip_maq'));
    }

    public function tipo_maquinaria_update($id, Request $request){
        $tip_maq = Tipo_maquinaria::find($id);
        $tipo = $request->input('tipo_maquinaria');

        $tip_maq->update([
            'tipo_maquinaria' => $tipo
        ]);

        return redirect()->route('tipo_maquinaria.index')->with('mensaje', 'El tipo maquinaria editado exitosamente.');
    }

    public function tipo_maquinaria_destroy($id){
        Tipo_maquinaria::destroy($id);

        return redirect()->route('tipo_maquinaria.index')->with('mensaje', 'El tipo maquinaria se elimino exitosamente.');  
    }
}