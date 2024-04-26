<?php

namespace App\Http\Controllers\Ingenieria\Servicios\Partes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
//agregamos 
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Models\Cambre\Orden;
use App\Models\Cambre\Estado;
use App\Models\Cambre\Estado_manufactura;
use App\Models\Cambre\Estado_mecanizado;
use App\Models\Cambre\Parte;
use App\Models\Cambre\Parte_trabajo;
use App\Models\Cambre\Parte_mecanizado;
use App\Models\Cambre\Parte_manufactura;
use App\Models\Cambre\Responsabilidad;
use App\Models\Cambre\Rol_empleado;
use App\Models\Cambre\Maquinaria;
use App\Models\Cambre\Parte_mecanizado_x_maquinaria;
class ParteController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        //  $this->middleware('permission:VER-ROL|CREAR-ROL|EDITAR-ROL|BORRAR-ROL', ['only' => ['index','buscarrol']]);
        //  $this->middleware('permission:CREAR-ROL', ['only' => ['create','store','creargrupo','guardargrupo','storegrupoNuevo']]);
        //  $this->middleware('permission:EDITAR-ROL', ['only' => ['edit','update','storegrupoEdit','storegrupo']]);
        //  $this->middleware('permission:BORRAR-ROL', ['only' => ['destroy','eliminarmenu']]);
        //  $this->middleware('permission:VER-USUARIO', ['only' => ['buscarvista','creargrupo','buscarordengrupo','buscarmenus','buscarmenu','vistas','editarmenu']]);

    }

    public function index(Request $request)
    {  
        
    }
    
    public function indexOrden($id, $tipo_orden){
        $orden = Orden::find(base64url_decode($id));

        if (Auth::user()->hasRole('SUPERVISOR')) {
            $editable = '';
            $editarEstado = 1;
            $estados = Estado::orderBy('id_estado')->pluck('nombre_estado', 'id_estado');
        } else {
            $editable = 'readonly';
            $estados = Estado::whereIn('id_estado', [1, 6, 7])->orderBy('nombre_estado')->pluck('nombre_estado', 'id_estado');
            $editarEstado = 0;

            if (in_array($orden->getIdEstado(), [1, 6, 7])) {
                $editarEstado = 1;
            }
        }

        $estados_manufactura = Estado_manufactura::orderBy('id_estado_manufactura')->pluck('nombre_estado_manufactura','id_estado_manufactura');
        $estados_mecanizado = Estado_mecanizado::orderBy('id_estado_mecanizado')->pluck('nombre_estado_mecanizado','id_estado_mecanizado');
        $maquinas = Maquinaria::orderBy('id_maquinaria')->pluck('alias_maquinaria','id_maquinaria');
       
        return view('Ingenieria.Servicios.Partes.show', compact('orden', 'editable', 'estados', 'estados_manufactura', 'estados_mecanizado', 'maquinas', 'tipo_orden', 'editarEstado'));
    }

    public function create(Request $request)
    {
        return view('Informatica.GestionUsuarios.roles.crear');
        $name = $request->query->get('name');

        if ($name =='') {
            //Con paginación
            $permission = Permission::orderBy('updated_at', 'desc')->get();
            return view('Coordinacion.Informatica.GestionUsuarios.roles.crear',compact('permission'));
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            $name = strtoupper($name);
            $permission = Permission::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->get();
            //$permission = Permission::whereRaw('UPPER(name) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('updated_at', 'desc')->get(); 
            return view('Coordinacion.Informatica.GestionUsuarios.roles.crear',compact('permission'));
        }
        
    }
    
    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'id_orden' => 'required',
            'observaciones' => 'required',
            'fecha_limite' => 'required',
            'fecha' => 'required',
            'horas' => 'required',
            'minutos' => 'required',
        ]);

        $orden = Orden::find($request->input('id_orden'));
        $responsable = $orden->getObjResponsable();
        $puesto = $responsable->getPuestoEmpleado;
        
        $fecha_limite = $request->input('fecha_limite');

        $fecha = $request->input('fecha');

        $observaciones = $request->input('observaciones');

        $opcion =  $orden->getOrdenDe->getTipoOrden();

        $fecha_carga = Carbon::now()->format('Y-m-d H:i:s');

        $horas = $request->input('horas') . ':' . $request->input('minutos');
        
        $costo = $request->input('horas')*$puesto->costo_hora + $request->input('minutos') * ($puesto->costo_hora/60);

        switch ($opcion) {
            case 1:
                $this->validate($request, [
                    'estado' => 'required'
                ]);

                $estado = $request->input('estado');

                $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();

                $responsabilidad = Responsabilidad::create([
                    'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                    'id_rol_empleado' => $rol_empleado->id_rol_empleado
                ]);

                $parte = Parte::create([
                            'observaciones' => $observaciones,
                            'fecha' => $fecha,
                            'fecha_limite' => $fecha_limite,
                            'fecha_carga' => $fecha_carga,
                            'horas' => $horas,
                            'costo' => $costo,
                            'id_orden' => $orden->id_orden,
                            'id_responsabilidad' => $responsabilidad->id_responsabilidad
                        ]);
                Parte_trabajo::create([
                    'id_estado' => $estado,
                    'id_parte' => $parte->id_parte
                ]);
                return redirect()->back()->with('mensaje','Parte de trabajo creado con éxito!.');
                // return redirect()->route('orden.partes', [base64url_encode($orden->id_orden), 1])->with('mensaje','Parte de trabajo creado con éxito!.');                       
                break;
            case 2:
                $this->validate($request, [
                    'estado' => 'required'
                ]);

                $estado = $request->input('estado');

                $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();

                $responsabilidad = Responsabilidad::create([
                    'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                    'id_rol_empleado' => $rol_empleado->id_rol_empleado
                ]);

                $parte = Parte::create([
                            'observaciones' => $observaciones,
                            'fecha' => $fecha,
                            'fecha_limite' => $fecha_limite,
                            'fecha_carga' => $fecha_carga,
                            'horas' => $horas,
                            'costo' => $costo,
                            'id_orden' => $orden->id_orden,
                            'id_responsabilidad' => $responsabilidad->id_responsabilidad
                        ]);
                Parte_manufactura::create([
                    'id_estado_manufactura' => $estado,
                    'id_parte' => $parte->id_parte
                ]);
                return redirect()->back()->with('mensaje','Parte de manufactura creado con éxito!.');
                //return redirect()->route('orden.partes', [base64url_encode($orden->id_orden), 2])->with('mensaje','Parte de manufactura creado con éxito!.');                       
                break;
            case 3:
                $this->validate($request, [
                    'estado' => 'required'
                ]);

                $estado = $request->input('estado');
                $horas_maquina = $request->input('horas_maquina') . ':' . $request->input('minutos_maquina');
                $maquina = $request->input('maquina');

                $rol_empleado = Rol_empleado::where('nombre_rol_empleado', 'responsable')->first();

                $responsabilidad = Responsabilidad::create([
                    'id_empleado' => Auth::user()->getEmpleado->id_empleado,
                    'id_rol_empleado' => $rol_empleado->id_rol_empleado
                ]);

                $parte = Parte::create([
                            'observaciones' => $observaciones,
                            'fecha' => $fecha,
                            'fecha_limite' => $fecha_limite,
                            'fecha_carga' => $fecha_carga,
                            'horas' => $horas,
                            'costo' => $costo,
                            'id_orden' => $orden->id_orden,
                            'id_responsabilidad' => $responsabilidad->id_responsabilidad
                        ]);
                $parte_mecanizado = Parte_mecanizado::create([
                    'id_estado_mecanizado' => $estado,
                    'id_parte' => $parte->id_parte
                ]);
                
                if ($maquina) {
                    Parte_mecanizado_x_maquinaria::create([
                        'id_parte_mecanizado' => $parte_mecanizado->id_parte_mecanizado,
                        'id_maquinaria' => $maquina,
                        'horas_maquina' => $horas_maquina
                    ]);
                }
                

                return redirect()->back()->with('mensaje','Parte de mecanizado creado con éxito!.');
                //return redirect()->route('orden.partes', [base64url_encode($orden->id_orden), 3])->with('mensaje','Parte de mecanizado creado con éxito!.');                       
                break;
            default:
                # code...
                break;
        }
        return 1;                      
    }
    
    public function show($id)
    {
    }
    
    public function edit(Request $request, $id)
    {
    }
    
    public function update(Request $request, $id)
    {                      
    }
    
    public function destroy($id)
    {      
    }
    
    public function obtenerDatosDeUnaOrden($id){
        $orden = Orden::find($id);
        return ['orden' => $orden->nombre_orden, 'estado_orden' => $orden->getEstado(), 'etapa' => $orden->getEtapa->descripcion_etapa];
    }

    public function obtenerPartesDeUnaOrden($id)
    {
        $partes_arr = array();
        $orden = Orden::find($id);

        switch ($orden->getOrdenDe->getTipoOrden()) {
            case 1:
                $partes = DB::select('select p.id_parte, o.id_orden, p.fecha, p.fecha_limite, p.horas, e.nombre_estado, p.observaciones, emp.nombre_empleado, ret.supervisor from parte p
                                        inner join parte_trabajo pt on pt.id_parte = p.id_parte
                                        inner join orden o on o.id_orden = p.id_orden
                                        inner join responsabilidad_orden res_o on res_o.id_orden = o.id_orden
                                        inner join estado e on e.id_estado = pt.id_estado
                                        inner join responsabilidad res on res.id_responsabilidad = p.id_responsabilidad
                                        inner join empleado emp on emp.id_empleado = res.id_empleado
                                        inner join (select o.id_orden, emp.nombre_empleado as supervisor 
                                                        from orden o
                                                            inner join responsabilidad_orden res_o on res_o.id_orden = o.id_orden
                                                            inner join responsabilidad res on res.id_responsabilidad = res_o.id_responsabilidad 
                                                            inner join empleado emp on emp.id_empleado = res.id_empleado
                                                            where res.id_rol_empleado = 3 and o.id_orden = ?) as ret on ret.id_orden = o.id_orden
                                                        where o.id_orden = ?
                                        order by p.id_parte;', [$id, $id]);
                foreach ($partes as $parte) {
                    array_push($partes_arr, (object)[
                        'id_parte' => $parte->id_parte,
                        'observaciones' => $parte->id_parte,
                        'estado' => $parte->id_parte,
                        'responsable' => $parte->nombre_empleado,
                        'fecha' => $parte->fecha,
                        'fecha_limite' => $parte->fecha_limite ?? '-',
                        'horas' => $parte->horas,
                        'supervisor' => $parte->supervisor,
                        // 'orden' => $parte->nombre_orden,
                        // 'etapa' => $parte->descripcion_etapa,
                        // 'estado_orden' => $parte->nombre_estado,
                        // 'maquinaria' => $parte->getParteDe->getParteMecxMaq->first()->getMaquinaria->codigo_maquinaria ?? '-',
                        // 'horas_maquinaria' => $parte->getParteDe->getParteMecxMaq->first() ? $parte->getParteDe->getParteMecxMaq->first()->horas_maquina : '-'
                        ]);
                }
                break;
            
            case 2:
                # code...
                break;
            
            case 3:
                # code...
                break;
        }
        

       /* $orden = Orden::find($id);
        $partes_arr = array();

        foreach ($orden->getPartes as $parte) {
            if ($orden->getOrdenDe->getTipoOrden() == 3) {
                array_push($partes_arr, (object)[
                    'id_parte' => $parte->id_parte,
                    'observaciones' => $parte->observaciones,
                    'estado' => $parte->getParteDe->getNombreEstado(),
                    'responsable' => $parte->getResponsable->getEmpleado->nombre_empleado,
                    'fecha' => $parte->fecha,
                    'fecha_limite' => $parte->fecha_limite ?? '-',
                    'horas' => $parte->horas,
                    'supervisor' => $parte->getOrden->getSupervisor(),
                    'orden' => $orden->nombre_orden,
                    'etapa' => $orden->getEtapa->descripcion_etapa,
                    'estado_orden' => $orden->getEstado(),
                    'maquinaria' => $parte->getParteDe->getParteMecxMaq->first()->getMaquinaria->codigo_maquinaria ?? '-',
                    'horas_maquinaria' => $parte->getParteDe->getParteMecxMaq->first() ? $parte->getParteDe->getParteMecxMaq->first()->horas_maquina : '-'
                    ]);
            } else {
                array_push($partes_arr, (object)[
                    'id_parte' => $parte->id_parte,
                    'observaciones' => $parte->observaciones,
                    'estado' => $parte->getParteDe->getNombreEstado(),
                    'responsable' => $parte->getResponsable->getEmpleado->nombre_empleado,
                    'fecha' => $parte->fecha,
                    'fecha_limite' => $parte->fecha_limite ?? '-',
                    'horas' => $parte->horas,
                    'supervisor' => $parte->getOrden->getSupervisor(),
                    'orden' => $orden->nombre_orden,
                    'etapa' => $orden->getEtapa->descripcion_etapa,
                    'estado_orden' => $orden->getEstado(),
                    ]);
            } 
        } 

        return $partes_arr; */
        
        return $partes_arr;
    }
}