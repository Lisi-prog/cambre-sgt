<?php

namespace App\Http\Controllers\Ingenieria\Servicios\Proyectos;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Cambre\Prefijo_proyecto;

class PrefijoProyectoController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permission:VER-MENU-PROYECTO', ['only' => ['index']]);
        // $this->middleware('permission:MODIFICAR-PRIORIDAD-PROYECTO', ['only' => ['actualizarPrioridadServicio']]); 
        //  $this->middleware('permission:CREAR-PERMISO', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-PERMISO', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-PERMISO', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {        
        $prefijos = Prefijo_proyecto::orderBy('nombre_prefijo_proyecto')->get();
        return view('Ingenieria.Servicios.Proyectos.prefijo.index', compact('prefijos'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre_prefijo' => 'required',
            'descripcion' => 'required'
        ],
        [
            'nombre_prefijo.required' => 'Se necesita el prefijo del proyecto'
        ]);

        $prefijo_proyecto = strtoupper($request->input('nombre_prefijo'));
        $descripcion_prefijo = $request->input('descripcion');

        try {
            Prefijo_proyecto::create([
                'nombre_prefijo_proyecto' => $prefijo_proyecto,
                'descripcion_prefijo_proyecto' => $descripcion_prefijo
            ]);
            return redirect()->route('prefijo_proyecto.index')->with('mensaje', 'El prefijo proyecto se ha creado con exito.');    
        } catch (\Throwable $th) {
            return redirect()->route('prefijo_proyecto.index')->with('error', 'Ocurrio un error al crear el prefijo proyecto.');    
        }                     
    }

    public function show($id)
    {
        
    }
    
    public function edit($id)
    {
        $prefijo = Prefijo_proyecto::find($id);
        return view('Ingenieria.Servicios.Proyectos.prefijo.editar',compact('prefijo'));
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre_prefijo' => 'required',
            'descripcion' => 'required'
        ],
        [
            'nombre_prefijo.required' => 'Se necesita el prefijo del proyecto'
        ]);

        $prefijo_proyecto = strtoupper($request->input('nombre_prefijo'));
        $descripcion_prefijo = $request->input('descripcion');

        $prefijo = Prefijo_proyecto::find($id);

        try {
            $prefijo->update([
                'nombre_prefijo_proyecto' => $prefijo_proyecto,
                'descripcion_prefijo_proyecto' => $descripcion_prefijo,
            ]);
            return redirect()->route('prefijo_proyecto.index')->with('mensaje', 'El prefijo proyecto se ha editado con exito.');     
        } catch (\Throwable $th) {
            return redirect()->route('prefijo_proyecto.index')->with('error', 'Ocurrio un error al editar el prefijo proyecto.');     
        }                      
    }
    
    public function destroy($id)
    {
        $prefijo = Prefijo_proyecto::find($id);

        Prefijo_proyecto::destroy($id);

        return redirect()->route('prefijo_proyecto.index')->with('mensaje', 'El prefijo proyecto se ha borrado con exito.');               
    }
   
}