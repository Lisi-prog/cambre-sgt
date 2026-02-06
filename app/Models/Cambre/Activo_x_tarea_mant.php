<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Activo_x_tarea_mant extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'activo_x_tarea_mant';

    protected $primaryKey = 'id_activo_x_tarea_mant';

    public $incrementing = true;

    protected $fillable = [ 
        'id_activo', 'id_tarea_mantenimiento'
    ];

    public function getTareaMantenimiento()
    {
        return $this->hasOne(Tarea_mantenimiento::class, 'id_tarea_mantenimiento', 'id_tarea_mantenimiento');
    }

    public function getActivo()
    {
        return $this->hasOne(Activo::class, 'id_activo', 'id_activo');
    }
}