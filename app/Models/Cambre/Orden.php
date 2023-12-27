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
        'id_etapa'
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

    public function getFechaLimite(){
        return $this->getPartes->sortByDesc('id_orden_trabajo')->first()->fecha_limite;
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

    public function getNombreResponsable(){
        $responsable = '';
        foreach ($this->getResponsabilidaOrden as $resp_orden) {
            if(strcasecmp($resp_orden->getResponsabilidad->getRol->nombre_rol_empleado, 'responsable') == 0){
                $responsable = $resp_orden->getResponsabilidad->getEmpleado->nombre_empleado;
            }
        }
        return $responsable;
    }

    public function getCalculoHorasReales()
    {
        $partes = $this->hasMany(Parte::class, 'id_orden');
        if($partes){
            $horas_estimadas = 0;
            $minutos_estimados = 0;
            
            foreach($partes as $parte){
                $horas_estimadas += substr($parte->horas, 0, 2);
                $minutos_estimados += substr($parte->horas, 3, 2);
                if($minutos_estimados >= 60){
                    $minutos_estimados -= 60;
                    $horas_estimadas += 1;
                }
            }
            if(strlen($horas_estimadas) < 2){
                $horas_estimadas = '0'. $horas_estimadas;
            }
            if(strlen($minutos_estimados) < 2){
                $minutos_estimados = '0'. $minutos_estimados;
            }
            $duracion_estimada = $horas_estimadas . ':' . $minutos_estimados;
            return $duracion_estimada;
        }else{
            return '00:00';
        }
    }

    public function getFechaFinalizacion()
    {   
        $estado = '';
        //return $parte = $this->hasMany(Parte::class, 'id_orden')->orderBy('id_parte', 'desc')->first();
        $parte = Parte::where('id_orden', $this->id_orden)->first();

        $parte_trabajo = Parte_trabajo::where('id_parte', $parte->id_parte)->first();
        $parte_mecanizado = Parte_mecanizado::where('id_parte', $parte->id_parte)->first();
        $parte_manufactura = Parte_manufactura::where('id_parte', $parte->id_parte)->first();
        $parte_mantenimiento = Parte_mantenimiento::where('id_parte', $parte->id_parte)->first();

        if ($parte_trabajo){
            $estado = $parte_trabajo->getNombreEstado();
        }elseif ($parte_mecanizado){
            $estado = $parte_mecanizado->getNombreEstado();
        }elseif ($parte_manufactura) {
            $estado = $parte_manufactura->getEstado;
        }elseif ($parte_mantenimiento) {
            $estado = $parte_mantenimiento->getEstado;
        }
        if($estado == 'Completo' || $estado == 'Pieza finalizada' ){
            $año = substr($parte->fecha_carga, 0, 4);
            $mes = substr($parte->fecha_carga, 5, 2);
            $dia = substr($parte->fecha_carga, 8, 2);
            return ($dia . '-' . $mes . '-' . $año);
        }else{
            return '__-__-____';
        }
    }

    public function getOrdenDe(){
        // return $this->hasOne(Parte_manufactura::class, 'id_parte');
        // return count(Orden_trabajo::where('id_orden', $this->id_orden)->get());

        if (count(Orden_trabajo::where('id_orden', $this->id_orden)->get()) == 1) {
            return $this->hasOne(Orden_trabajo::class, 'id_orden');
        }

        if (count(Orden_mecanizado::where('id_orden', $this->id_orden)->get()) == 1) {
            return $this->hasOne(Orden_mecanizado::class, 'id_orden');
        }

        if (count(Orden_manufactura::where('id_orden', $this->id_orden)->get()) == 1) {
            return $this->hasOne(Orden_manufactura::class, 'id_parte');
        }

        if (count(Orden_mantenimiento::where('id_orden', $this->id_orden)->get()) == 1) {
            return $this->hasOne(Orden_mantenimiento::class, 'id_orden');
        }
    }
}