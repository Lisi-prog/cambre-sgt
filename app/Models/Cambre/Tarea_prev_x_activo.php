<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tarea_prev_x_activo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tarea_prev_x_activo';

    protected $primaryKey = 'id_tarea_prev_x_activo';

    public $incrementing = true;

    protected $fillable = [ 
        'id_activo', 'id_tarea_mantenimiento', 'intervalo_dias', 'cant_golpes', 'fecha_ultima_ejecucion'
    ];

    public function getActivo()
    {
        return $this->hasOne(Activo::class, 'id_activo', 'id_activo');
    }

    public function getTareaMantenimiento(){
        return $this->hasOne(Tarea_mantenimiento::class, 'id_tarea_mantenimiento', 'id_tarea_mantenimiento');
    }
}