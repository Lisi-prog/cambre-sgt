<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Solicitud extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'solicitud';

    protected $primaryKey = 'id_solicitud';

    public $incrementing = true;

    protected $fillable = [ 
        'id_prioridad_solicitud',
        'id_estado_solicitud',
        'nombre_solicitante',
        'descripcion_solicitud',
        'fecha_carga',
        'fecha_requerida',
        'descripcion_urgencia'
    ];

    public function getRequerimientoIngenieria()
    {
        return $this->belongsTo(Requerimiento_de_ingenieria::class, 'id_solicitud');
    }

    public function getEstadoSolicitud()
    {
        return $this->belongsTo(Estado_solicitud::class, 'id_estado_solicitud');
    }

    public function getPrioridadSolicitud()
    {
        return $this->belongsTo(Prioridad_solicitud::class, 'id_prioridad_solicitud');
    }
}