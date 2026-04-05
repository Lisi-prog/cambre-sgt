<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tarea_mantenimiento extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tarea_mantenimiento';

    protected $primaryKey = 'id_tarea_mantenimiento';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_tarea', 'id_ejecucion', 'id_zona_tarea'
    ];

    public function getEjecucion()
    {
        return $this->belongsTo(Tarea_ejecucion::class, 'id_ejecucion');
    }   

    public function getZonaTarea()
    {
        return $this->belongsTo(Zona_tarea::class, 'id_zona_tarea');
    }
}