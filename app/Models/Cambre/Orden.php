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
}