<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tarea_prev_x_tipo_activo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tarea_prev_x_tipo_activo';

    protected $primaryKey = 'id_tarea_prev_x_tipo_activo';

    public $incrementing = true;

    protected $fillable = [ 
        'id_tipo_activo', 'id_tarea_mantenimiento', 'intervalo_dias', 'cant_golpes', 'fecha_ultima_ejecucion'
    ];

    public function getTipoActivo()
    {
        return $this->hasOne(Tipo_activo::class, 'id_tipo_activo', 'id_tipo_activo');
    }

    public function getTareaMantenimiento(){
        return $this->hasOne(Tarea_mantenimiento::class, 'id_tarea_mantenimiento', 'id_tarea_mantenimiento');
    }
}