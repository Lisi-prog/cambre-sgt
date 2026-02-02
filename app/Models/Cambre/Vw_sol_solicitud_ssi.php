<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_sol_solicitud_ssi extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'vw_sol_solicitud_ssi';

    protected $primaryKey = 'id_solicitud';

    public $incrementing = true;

    protected $fillable = [ 
        'id_solicitud',
        'fecha_carga',
        'id_empleado',
        'nombre_solicitante',
        'nombre_sector',
        'descripcion_solicitud',
        'fecha_requerida',
        'id_estado_solicitud',
        'nombre_estado_solicitud',
        'nombre_prioridad_solicitud',
        'id_servicio',
        'tipo'
    ];

    public function getServicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }

    public function getServicioDeIngenieria()
    {
        return $this->hasOne(Sol_servicio_de_ingenieria::class, 'id_solicitud');
    }

    public function getServicioDeMantenimiento()
    {
        return $this->hasOne(Sol_servicio_de_mantenimiento::class, 'id_solicitud');
    }
}