<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cambio_de_prioridad extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'cambio_de_prioridad';

    protected $primaryKey = 'id_cambio_de_prioridad';

    public $incrementing = true;

    protected $fillable = [ 
        'motivo',
        'prioridad_ant',
        'prioridad_nue',
        'fecha_carga',
        'id_empleado',
        'id_servicio'
    ];

    public function getResponsable()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function getServicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }


}