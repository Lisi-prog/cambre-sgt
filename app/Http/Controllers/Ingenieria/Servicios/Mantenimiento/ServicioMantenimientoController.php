<?php

namespace App\Http\Controllers\Ingenieria\Servicios\Mantenimiento;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class ServicioMantenimientoController extends Controller
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