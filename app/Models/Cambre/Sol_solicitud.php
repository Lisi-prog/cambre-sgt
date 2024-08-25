<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sol_solicitud extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'sol_solicitud';

    protected $primaryKey = 'id_solicitud';

    public $incrementing = true;

    protected $fillable = [ 
        'id_prioridad_solicitud',
        'id_estado_solicitud',
        'nombre_solicitante',
        'descripcion_solicitud',
        'fecha_carga',
        'fecha_requerida',
        'descripcion_urgencia',
        'id_servicio',
        'id_empleado'
    ];

    public function getRequerimientoIngenieria()
    {
        return $this->hasOne(Sol_requerimiento_de_ingenieria::class, 'id_solicitud');
    }

    public function getPropuestaDeMejora()
    {
        return $this->hasOne(Sol_propuesta_de_mejora::class, 'id_solicitud');
    }

    public function getServicioDeMantenimiento()
    {
        return $this->hasOne(Sol_servicio_de_mantenimiento::class, 'id_solicitud');
    }

    public function getServicioDeIngenieria()
    {
        return $this->hasOne(Sol_servicio_de_ingenieria::class, 'id_solicitud');
    }

    public function getEstadoSolicitud()
    {
        return $this->belongsTo(Sol_estado_solicitud::class, 'id_estado_solicitud');
    }

    public function getPrioridadSolicitud()
    {
        return $this->belongsTo(Sol_prioridad_solicitud::class, 'id_prioridad_solicitud');
    }

    public function getEmpleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function getServicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }

    public function getArchivos()
    {
        return $this->hasMany(Sol_archivo_solicitud::class, 'id_solicitud');
    }

    /* public function getSolicitudDe(){
        if (count(Sol_requerimiento_de_ingenieria::where('id_solicitud', $this->id_solicitud)->get()) == 1) {
            return $this->hasOne(Sol_requerimiento_de_ingenieria::class, 'id_solicitud');
        }

        if (count(Sol_propuesta_de_mejora::where('id_solicitud', $this->id_solicitud)->get()) == 1) {
            return $this->hasOne(Sol_propuesta_de_mejora::class, 'id_solicitud');
        }

        if (count(Sol_servicio_de_ingenieria::where('id_solicitud', $this->id_solicitud)->get()) == 1) {
            return $this->hasOne(Sol_servicio_de_ingenieria::class, 'id_solicitud');
        }
    } */

    public function getTipoDeSolicitud(){
        if (count(Sol_servicio_de_ingenieria::where('id_solicitud', $this->id_solicitud)->get()) == 1) {
            return 1;
        }

        if (count(Sol_propuesta_de_mejora::where('id_solicitud', $this->id_solicitud)->get()) == 1) {
            return 2;
        }

        if (count(Sol_requerimiento_de_ingenieria::where('id_solicitud', $this->id_solicitud)->get()) == 1) {
            return 3;
        }    
    }
}