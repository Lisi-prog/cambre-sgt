<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\HoraMinutoCast;

class Vw_orden_mecanizado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'vw_orden_mecanizado';

    protected $primaryKey = 'id_orden';

    public $incrementing = false;

    protected $fillable = [ 
        'prioridad_servicio',
        'id_servicio',
        'codigo_servicio',
        'nombre_servicio',
        'nombre_orden',
        'descripcion_etapa',
        'fecha_limite',
        'fecha_finalizacion',
        'responsable',
        'id_empleado_responsable',
        'supervisor',
        'id_empleado_supervisor',
        'nombre_estado',
        'total_horas'
    ];

    protected $casts = [
        'total_horas' => HoraMinutoCast::class
    ];
    
    public function scopeResponsable($query, $responsable)
    {
        if ($responsable == '') {
            return $query;
        } else{
            return $query->where('id_empleado_responsable', $responsable);
        }
        
    }

}