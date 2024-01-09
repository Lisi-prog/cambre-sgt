<?php

namespace App\Http\Controllers\Ingenieria\Solicitud;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use App\Models\Cambre\Prioridad_solicitud;
use App\Models\Cambre\Estado_solicitud;
use App\Models\Cambre\Solicitud;
use App\Models\Cambre\Requerimiento_de_ingenieria;
use App\Models\Cambre\Sector;

class SolicitudController extends Controller
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