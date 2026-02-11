<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tipo_activo_x_tarea_mant extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tipo_activo_x_tarea_mant';

    protected $primaryKey = 'id_tipo_activo_x_tarea_mant';

    public $incrementing = true;

    protected $fillable = [ 
        'id_tipo_activo', 'id_tarea_mantenimiento'
    ];

    public function getTareaMantenimiento()
    {
        return $this->hasOne(Tarea_mantenimiento::class, 'id_tarea_mantenimiento', 'id_tarea_mantenimiento');
    }

    public function getTipoActivo()
    {
        return $this->hasOne(Tipo_activo::class, 'id_tipo_activo', 'id_tipo_activo');
    }
}