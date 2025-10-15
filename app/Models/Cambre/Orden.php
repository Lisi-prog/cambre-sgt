<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Orden extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'orden';

    protected $primaryKey = 'id_orden';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_orden',
        'fecha_inicio',
        'duracion_estimada',
        'id_etapa',
        'costo_estimado',
        'observaciones'
    ];

    public function getEtapa()
    {
        return $this->belongsTo(Etapa::class, 'id_etapa');
    }

    public function getPartes()
    {
        return $this->hasMany(Parte::class, 'id_orden');
    }
    
    public function getResponsabilidaOrden()
    {
        return $this->hasMany(Responsabilidad_orden::class, 'id_orden');
    }

    public function getOrdenTrabajo()
    {
        return $this->hasOne(Orden_trabajo::class, 'id_orden');
    }

    public function getOrdenMecanizado()
    {
        return $this->hasOne(Orden_mecanizado::class, 'id_orden');
    }

    public function getFechaLimite(){
        return $this->getPartes->sortByDesc('id_parte')->first()->fecha_limite;
    }

    public function getFechaFinalizado(){
        return $this->getPartes->sortByDesc('id_parte')->first()->fecha;
    }

    public function getSupervisor(){
        $supervisor = '';
        foreach ($this->getResponsabilidaOrden as $resp_orden) {
            if(strcasecmp($resp_orden->getResponsabilidad->getRol->nombre_rol_empleado, 'supervisor') == 0){
                $supervisor = $resp_orden->getResponsabilidad->getEmpleado->nombre_empleado;
            }
        }
        return $supervisor;
    }

    public function getEmailSupervisor(){
        $supervisor = '';
        foreach ($this->getResponsabilidaOrden as $resp_orden) {
            if(strcasecmp($resp_orden->getResponsabilidad->getRol->nombre_rol_empleado, 'supervisor') == 0){
                $supervisor = $resp_orden->getResponsabilidad->getEmpleado->email_empleado;
            }
        }
        return $supervisor;
    }

    public function getNombreResponsable(){
        $responsable = '';
        foreach ($this->getResponsabilidaOrden as $resp_orden) {
            if(strcasecmp($resp_orden->getResponsabilidad->getRol->nombre_rol_empleado, 'responsable') == 0){
                $responsable = $resp_orden->getResponsabilidad->getEmpleado->nombre_empleado;
            }
        }
        return $responsable;
    }

    public function getEmailResponsable(){
        $responsable = '';
        foreach ($this->getResponsabilidaOrden as $resp_orden) {
            if(strcasecmp($resp_orden->getResponsabilidad->getRol->nombre_rol_empleado, 'responsable') == 0){
                $responsable = $resp_orden->getResponsabilidad->getEmpleado->email_empleado;
            }
        }
        return $responsable;
    }
///////////////////////////////////////////////////
//Devuelven el objeto empleado entero
    public function getObjSupervisor(){
        $supervisor = '';
        foreach ($this->getResponsabilidaOrden as $resp_orden) {
            if(strcasecmp($resp_orden->getResponsabilidad->getRol->nombre_rol_empleado, 'supervisor') == 0){
                $supervisor = $resp_orden->getResponsabilidad->getEmpleado;
            }
        }
        return $supervisor;
    }
    public function getObjResponsable(){
        $responsable = '';
        foreach ($this->getResponsabilidaOrden as $resp_orden) {
            if(strcasecmp($resp_orden->getResponsabilidad->getRol->nombre_rol_empleado, 'responsable') == 0){
                $responsable = $resp_orden->getResponsabilidad->getEmpleado;
            }
        }
        return $responsable;
    }
//////////////////////////////////////////////////
    public function getCalculoHorasReales()
    {
        $partes = Parte::where('id_orden', $this->id_orden)->get();
        if($partes){
            $horas_reales = 0;
            $minutos_reales = 0;
            
            foreach($partes as $parte){
                $horas_reales += strstr($parte->horas, ':', true);
                
                if (preg_match_all('/\:(.*?)\:/', $parte->horas, $matches)) {
                    $minutos_reales += $matches[1][0];
                }

                if($minutos_reales >= 60){
                    $minutos_reales -= 60;
                    $horas_reales += 1;
                }
            }
            
            if(strlen($horas_reales) < 2){
                $horas_reales = '0'. $horas_reales;
            }
            if(strlen($minutos_reales) < 2){
                $minutos_reales = '0'. $minutos_reales;
            }
            $duracion_real = $horas_reales . ':' . $minutos_reales;
            return $duracion_real;
        }else{
            return '00:00';
        }
    }

    public function getCostoReal()
    {
        $duracion_real = $this->getCalculoHorasReales();
        $horas_reales = 0;
        $minutos_reales = 0;

        $horas_reales += strstr($duracion_real, ':', true);
        if (preg_match_all('/\:(.*?)\:/', $duracion_real, $matches)) {
            $minutos_reales += $matches[1][0];
        }

        $responsable = $this->getObjResponsable();
        $puesto_responsable = Puesto_empleado::find($responsable->id_puesto_empleado);
        $precio_h = $puesto_responsable->costo_hora;

        $costo = $horas_reales * $precio_h + $minutos_reales * ($precio_h/60);
        return round($costo, 2);
    }

    public function getCostoEstimado()
    {
        $duracion_real = $this->duracion_estimada;
        $horas_reales = 0;
        $minutos_reales = 0;

        $horas_reales += strstr($duracion_real, ':', true);
        if (preg_match_all('/\:(.*?)\:/', $duracion_real, $matches)) {
            $minutos_reales += $matches[1][0];
        }

        $responsable = $this->getObjResponsable();
        $puesto_responsable = Puesto_empleado::find($responsable->id_puesto_empleado);
        $precio_h = $puesto_responsable->costo_hora;

        $costo = $horas_reales * $precio_h + $minutos_reales * ($precio_h/60);
        return round($costo, 2);
    }

    public function getCostoRealGuardado()
    {
        $partes = Parte::where('id_orden', $this->id_orden)->get();
        $costo = 0;
        foreach ($partes as $parte) {
            $costo = $costo + $parte->costo;
        }
        return round($costo, 2);
    }

    public function getFechaFinalizacion()
    {   
        $estado = '';
        //return $parte = $this->hasMany(Parte::class, 'id_orden')->orderBy('id_parte', 'desc')->first();
        $parte = Parte::where('id_orden', $this->id_orden)->orderBy('id_parte', 'desc')->first();

        $parte_trabajo = Parte_trabajo::where('id_parte', $parte->id_parte)->first();
        $parte_mecanizado = Parte_mecanizado::where('id_parte', $parte->id_parte)->first();
        $parte_manufactura = Parte_manufactura::where('id_parte', $parte->id_parte)->first();
        $parte_mantenimiento = Parte_mantenimiento::where('id_parte', $parte->id_parte)->first();

        if ($parte_trabajo){
            $estado = $parte_trabajo->getNombreEstado();
        }elseif ($parte_mecanizado){
            $estado = $parte_mecanizado->getNombreEstado();
        }elseif ($parte_manufactura) {
            $estado = $parte_manufactura->getNombreEstado();
        }elseif ($parte_mantenimiento) {
            $estado = $parte_mantenimiento->getNombreEstado();
        }
        if($estado == 'Completo' || $estado == 'Pieza finalizada' ){
            $año = substr($parte->fecha, 0, 4);
            $mes = substr($parte->fecha, 5, 2);
            $dia = substr($parte->fecha, 8, 2);
            // return ($dia . '-' . $mes . '-' . $año);
            return ( $año . '-' . $mes . '-' . $dia);
        }else{
            // return '__-__-____';
            return '____-__-__';
        }
    }

    public function getOrdenDe(){
        if (count(Orden_trabajo::where('id_orden', $this->id_orden)->get()) == 1) {
            return $this->hasOne(Orden_trabajo::class, 'id_orden');
        }

        if (count(Orden_mecanizado::where('id_orden', $this->id_orden)->get()) == 1) {
            return $this->hasOne(Orden_mecanizado::class, 'id_orden');
        }

        if (count(Orden_manufactura::where('id_orden', $this->id_orden)->get()) == 1) {
            return $this->hasOne(Orden_manufactura::class, 'id_orden');
        }

        if (count(Orden_mantenimiento::where('id_orden', $this->id_orden)->get()) == 1) {
            return $this->hasOne(Orden_mantenimiento::class, 'id_orden');
        }
    }

    public function getFinalizado()
    {   
        return $this->getPartes->sortByDesc('id_parte')->first()->getParteDe->getFinalizado();
    }

    public function getEstado()
    {
        return $this->getPartes->sortByDesc('id_parte')->first()->getParteDe->getNombreEstado();
    }

    public function getIdEstado()
    {
        return $this->getPartes->sortByDesc('id_parte')->first()->getParteDe->getIdEstado();
    }

    public function getduracionHoraMinuto(){
        return substr($this->duracion_estimada, 0, -3);
    }
}