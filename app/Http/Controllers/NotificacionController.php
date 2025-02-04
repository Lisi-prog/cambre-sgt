<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Cambre\Not_notificacion;

class NotificacionController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        //  $this->middleware('permission:VER-PERMISO|CREAR-PERMISO|EDITAR-PERMISO|BORRAR-PERMISO', ['only' => ['index']]);
        //  $this->middleware('permission:CREAR-PERMISO', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-PERMISO', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-PERMISO', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {   
        $notificaciones = Not_notificacion::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('Informatica.Notificaciones.index', compact('notificaciones'));
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

    public function marcarComoLeidoNotUsuario($id)
    {
        $notificaciones = Not_notificacion::where('user_id', $id)->where('leido', 0)->get();

        if (count($notificaciones) != 0) {
            foreach ($notificaciones as $notif){
                $notif->leido = 1;
                $notif->save();
            }
            return 1;
        } else {
            return 0;
        }
    }
}