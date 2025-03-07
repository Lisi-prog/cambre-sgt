<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\HoraMinutoCast;

class Vw_gest_orden_mecanizado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'vw_gest_orden_mecanizado';

    protected $primaryKey = 'vw_gest_orden_mecanizado';

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
        'costo_real',
        'id_orden_manufactura',
        'nombre_manufactura',
        'horas_estimada',
        'horas_real'
    ];

    protected $casts = [
        'horas_estimada' => HoraMinutoCast::class
    ];
}