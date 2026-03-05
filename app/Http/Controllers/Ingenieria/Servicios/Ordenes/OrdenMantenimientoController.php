<?php

namespace App\Http\Controllers\Ingenieria\Servicios\Ordenes;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use \PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Cambre\Estado_hdr;
use App\Models\Cambre\Operacion;
use App\Models\Cambre\Empleado;
use App\Models\Cambre\Maquinaria;
use App\Models\Cambre\Vw_operaciones_de_hdr;
use App\Models\Cambre\Orden_mantenimiento;
use App\Models\Cambre\Tipo_orden_mantenimiento;


class OrdenMantenimientoController extends Controller
{

public function index(){
        $flt_operaciones = Operacion::orderBy('nombre_operacion')->pluck('nombre_operacion');
        $orden_mantimiento = Tipo_orden_mantenimiento::where('id_tipo_orden_mantenimiento', '<>', 3)->orderBy('id_tipo_orden_mantenimiento')->pluck('nombre_tipo_orden_mantenimiento');
        $flt_operaciones = $flt_operaciones->merge($orden_mantimiento)->sort();
        $flt_operaciones_tec = [];

        if (Auth::user()->hasRole('SUPERVISOR') || Auth::user()->hasRole('ADMIN')) {
        } else {
            $opeDeUsuario = Auth::user()->getOperacionesValidas();
            $flt_operaciones_tec = Operacion::whereIn('id_operacion', $opeDeUsuario)->orderBy('nombre_operacion')->pluck('nombre_operacion');
        }

        $flt_estados = Estado_hdr::orderBy('id_estado_hdr')->pluck('nombre_estado_hdr');
        $flt_maquinas = Maquinaria::orderBy('alias_maquinaria')->pluck('alias_maquinaria');
        

        $flt_proyectos =  collect(DB::select('select s.codigo_servicio 
                                        from operaciones_de_hdr op_hdr
                                        inner join hoja_de_ruta hdr on hdr.id_hoja_de_ruta = op_hdr.id_hoja_de_ruta
                                        inner join orden_mecanizado om on om.id_orden_mecanizado = hdr.id_orden_mecanizado
                                        inner join orden o on o.id_orden = om.id_orden
                                        inner join etapa et on et.id_etapa = o.id_etapa
                                        inner join servicio s on s.id_servicio = et.id_servicio
                                        group by s.id_servicio, s.codigo_servicio;'))->pluck('codigo_servicio');

        $flt_tecnicos = $this->obtenerTecnicosDeOperaciones();

        return view('Ingenieria.Servicios.HDR.operaciones.ordenes_mantenimiento', compact('flt_estados', 'flt_maquinas', 'flt_operaciones', 'flt_proyectos', 'flt_operaciones_tec', 'flt_tecnicos'));
    }

     public function obtenerTecnicosDeOperaciones(){
        return Empleado::orderBy('nombre_empleado')->activo()->HabilitadoOperacion()->get();
    }

    public function get_operaciones(Request $request){
       //return $request;
       
        $operaciones = Vw_operaciones_de_hdr::orderByRaw('ISNULL(prioridad), prioridad')
            ->orderByRaw('ISNULL(prioridad_servicio), prioridad_servicio')
            ->with('getHdr.getOrdMec');

        $operaciones_mantenimiento = [];
        if((!$request->res || in_array('-', $request->res))){
            $operaciones_mantenimiento = Orden_mantenimiento::with('getOrden.getEtapa.getServicio', 
            'getTipoOrdenMantenimiento')
            ->get()
            ->filter(function ($om) use ($request) {
                $estado = $om->getEstadoActual();
                if (in_array($estado, $request->est)) {
                    $om->estado_actual = $estado;
                    return true;
                }
                return false;
            })
            ->values();
            foreach($operaciones_mantenimiento as $om){
                $om->horas = $om->getOrden->getHoras();
            }
        }

        if($request->cod_serv){
            $operaciones = $operaciones->whereIn('codigo_servicio', $request->cod_serv);
        }
        if($request->sup){
            $operaciones = $operaciones->whereIn('nombre_operacion', $request->sup);
        }    
        if($request->res){
            if(in_array('-', $request->res)){
                $res = array_diff($request->res, ['-']);
                $operaciones = $operaciones->where(function ($q) use ($res) {
                    if (!empty($res)) {
                        $q->whereIn('codigo_maquinaria', $res)
                        ->orWhereNull('codigo_maquinaria');
                    } else {
                        $q->whereNull('codigo_maquinaria');
                    }
                });
            }else{
                $operaciones = $operaciones->whereIn('codigo_maquinaria', $request->res);
            }                
        }
        if($request->est){
            $operaciones = $operaciones->whereIn('nombre_estado_hdr', $request->est);
        }
        if($request->asig){
            $operaciones = $operaciones->whereIn('tecnico_asignado', $request->asig);
        }
        if($request->soloAct == 1){
            $operaciones = $operaciones->where('activo', 1);
        }

        $operaciones_todas['generales'] = $operaciones->get();
        $operaciones_todas['mantenimiento'] = $operaciones_mantenimiento;
    
    
        return $operaciones_todas;
    }
}

