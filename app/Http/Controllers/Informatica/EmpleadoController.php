<?php

namespace App\Http\Controllers\Informatica;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use App\Models\User;
use App\Models\Cambre\Empleado;
use App\Models\Cambre\Sector;
use App\Models\Cambre\Puesto_empleado;
use App\Models\Cambre\Em_not_x_empleado;
use App\Models\Cambre\Em_notificacion;
use App\Models\Cambre\Og_organigrama;

class EmpleadoController extends Controller
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
        // Obtener la estructura del organigrama con los empleados y sus supervisores
        $organigrama = Og_organigrama::with(['empleado', 'supervisor'])->get();

        // Convertir los datos a un formato que Google Charts pueda entender
        $datosOrganigrama = [];

        $sup_su = Empleado::find(1);

        $datosOrganigrama[] = [
            'id' => '1',
            'nombre' => $sup_su->nombre_empleado,
            'supervisor' => ''
        ];

        foreach ($organigrama as $relacion) {
            $empleado = $relacion->empleado;
            $supervisor = $relacion->supervisor;

            $idEmpleado = (string)$empleado->id_empleado;
            $nombreEmpleado = $empleado->nombre_empleado;
            $idSupervisor = $supervisor ? (string)$supervisor->id_empleado : '';

            // Añadir al array de datos
            $datosOrganigrama[] = [
                'id' => $idEmpleado,
                'nombre' => $nombreEmpleado,
                'supervisor' => $idSupervisor
            ];
        }
        
        $empleados = Empleado::orderBy('id_empleado')->get();
        return view('Informatica.Empleados.index',compact('empleados', 'datosOrganigrama'));
    }

    public function create()
    {
        $sectores = Sector::orderBy('nombre_sector')->pluck('nombre_sector', 'id_sector');
        $puestos = Puesto_empleado::orderBy('titulo_puesto_empleado')->pluck('titulo_puesto_empleado', 'id_puesto_empleado');
        $roles = Role::orderBy('name')->pluck('name', 'id');
        return view('Informatica.Empleados.crear',compact('sectores', 'puestos', 'roles'));
    }

    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'nombre_completo' => 'required',
            'email' => 'required',
            'puesto' => 'required',
            'sector' => 'required',
            'costo_hora' => 'required',
            'user_wb' => 'required'
        ]);

        $nombre = $request->input('nombre_completo');
        $email = $request->input('email');
        $puesto = $request->input('puesto');
        $sector = $request->input('sector');
        $costo_hora = $request->input('costo_hora');

        if ($request->input('telefono')) {
            $telefono = $request->input('telefono');
        }else{
            $telefono = null;
        }

        $opcion = $request->input('user_wb');
        switch ($opcion) {
            case 0:
                Empleado::create([
                    'nombre_empleado' => $nombre,
                    'email_empleado' => $email,
                    'telefono_empleado' => $telefono,
                    'id_puesto_empleado' => $puesto,
                    'costo_hora' => $costo_hora,
                    'id_sector' => $sector 
                ]);
                break;
            
            case 1:
                $this->validate($request, [
                    'password' => 'required',
                    'rol' => 'required'
                ]);

                $rol = $request->input('rol');

                $usuario = User::create([
                    'name' => $nombre,
                    'email' => $email,
                    'password' => Hash::make($request->input('password'))
                ]);

                $usuario->assignRole(Role::find($rol));

                Empleado::create([
                    'nombre_empleado' => $nombre,
                    'email_empleado' => $email,
                    'telefono_empleado' => $telefono,
                    'id_puesto_empleado' => $puesto,
                    'id_sector' => $sector,
                    'costo_hora' => $costo_hora,
                    'user_id' => $usuario->id
                ]);

                break;
        }
        return redirect()->route('tecnicos.index')->with('mensaje', 'Empleado creado exitosamente.');                     
    }
    
    public function show($id)
    {
    }
    
    public function edit($id)
    {
        $empleado = Empleado::find($id);
        $sectores = Sector::orderBy('nombre_sector')->pluck('nombre_sector', 'id_sector');
        $puestos = Puesto_empleado::orderBy('titulo_puesto_empleado')->pluck('titulo_puesto_empleado', 'id_puesto_empleado');
        $es_supervisor = $empleado->getUser->hasRole('SUPERVISOR');
        $per_avisos = collect(Em_not_x_empleado::where('id_empleado', $id)->get())->pluck('id_em_notificacion')->all();
        $op_nots = Em_notificacion::orderBy('nombre_em_notificacion')->get();
        $supervisores = $this->obtenerSupervisores();
        return view('Informatica.Empleados.editar',compact('empleado', 'sectores', 'puestos', 'es_supervisor', 'per_avisos', 'op_nots', 'supervisores'));
    }
    
    public function obtenerSupervisores(){
        $usuariosSupervisor = User::role('SUPERVISOR')->pluck('id')->toArray();
        return Empleado::whereIn('user_id', $usuariosSupervisor)->orderBy('nombre_empleado')->pluck('nombre_empleado', 'id_empleado');
    }

    public function update(Request $request, $id)
    {
        // return $request;
        $this->validate($request, [
            'nombre_completo' => 'required',
            'email' => 'required',
            'puesto' => 'required',
            'sector' => 'required',
            'costo_hora' => 'required'
        ]);

        $nombre = $request->input('nombre_completo');
        $email = $request->input('email');
        $puesto = $request->input('puesto');
        $sector = $request->input('sector');
        $costo_hora = $request->input('costo_hora');
        $esta_activo = $request->input('esta_activo');
        // $not_email_new = collect($request->input('notificaciones_email'));

        $not_emails_new  = collect($request->input('notificaciones_email'))->map(function ($value) {
            return (int) $value;
        });

        // $not_email_old = collect(Em_not_x_empleado::where('id_empleado', $id)->get())->pluck('id_em_notificacion')->all();
        // $diff_not_email = $not_email_new->diff($not_email_old);

        if ($request->input('telefono')) {
            $telefono = $request->input('telefono');
        }else{
            $telefono = null;
        }
        $empleado = Empleado::find($id);

        try {
                Em_not_x_empleado::where('id_empleado', $id)->delete();

                foreach ($not_emails_new as $noti_mail) {
                    Em_not_x_empleado::create([
                        'id_em_notificacion' =>$noti_mail,
                        'id_empleado' => $id
                    ]);
                }
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        if ($request->input('sup_di')) {
            $existe = Og_organigrama::where('id_empleado', $id)->first();
            if ($existe) {
                $existe->update([
                    'id_supervisor_directo' => $request->input('sup_di')
                ]);
            } else {
                Og_organigrama::create([
                    'id_empleado' => $id, 
                    'id_supervisor_directo' => $request->input('sup_di')
                ]);
            }
            
            
        }else{
            $existe = Og_organigrama::where('id_empleado', $id)->first();
            if ($existe) {
                $existe->delete();
            }
        }

        $empleado->update([
            'nombre_empleado' => $nombre,
            'email_empleado' => $email,
            'telefono_empleado' => $telefono,
            'id_puesto_empleado' => $puesto,
            'id_sector' => $sector,
            'costo_hora' => $costo_hora,
            'esta_activo' => $esta_activo
        ]);
    
        return redirect()->route('tecnicos.index')->with('mensaje','El usuario '.$nombre.' editado exitosamente.');                        
    }
    
    public function destroy($id)
    {
        $empleado = Empleado::find($id);
        Empleado::destroy($id);
        User::destroy($empleado->user_id);
        return redirect()->route('tecnicos.index')->with('mensaje', 'El empleado se elimino exitosamente.');               
    }

    public function buscarpermisospornombre($nombre){
        return Permission::where('name', 'like', '%'.$nombre.'%')->get();
    }
}