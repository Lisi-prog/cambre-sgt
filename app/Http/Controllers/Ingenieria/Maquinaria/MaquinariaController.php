<?php

namespace App\Http\Controllers\Ingenieria\Maquinaria;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Cambre\Sector;

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
        return view('Ingenieria.Maquinaria.index', compact('sectores', 'maquinaria'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {                     
    }
    
    public function show($id)
    {
    }
    
    public function edit($id)
    {
    }
    
    public function update(Request $request, $id)
    {                        
    }
    
    public function destroy($id)
    {            
    }

}