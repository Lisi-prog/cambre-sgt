<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Zona_tarea extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'zona_tarea';

    protected $primaryKey = 'id_zona_tarea';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_zona'
    ];

    public function getTiposActivo()
    {
        return $this->belongsToMany(
            Tipo_activo::class,
            'zona_tarea_x_tipo_activo',
            'id_zona_tarea',
            'id_tipo_activo'
        );
    }
}