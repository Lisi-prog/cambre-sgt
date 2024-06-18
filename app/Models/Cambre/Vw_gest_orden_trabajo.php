<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_gest_orden_trabajo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'vw_gest_orden_trabajo';

    protected $primaryKey = 'vw_gest_orden_trabajo';

    public $incrementing = false;

    protected $fillable = [ 
        'prioridad_servicio',
        'id_servicio',
        'codigo_servicio',
        'nombre_servicio',
        'id_orden',
        'nombre_orden',
        'descripcion_etapa',
        'fecha_limite',
        'fecha_finalizacion',
        'responsable',
        'id_empleado_responsable',
        'supervisor',
        'id_empleado_supervisor',
        'id_estado',
        'nombre_estado',
        'total_horas',
        'costo_estimado',
        'costo_real'
    ];

}