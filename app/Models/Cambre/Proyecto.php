<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Proyecto extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'proyecto';

    protected $primaryKey = 'id_proyecto';

    public $incrementing = false;

    protected $fillable = [ 
        'codigo_proyecto',
        'nombre_proyecto',
        'fecha_inicio',
        'fecha_limite',
        'id_responsabilidad',
        'id_estado',
        'id_tipo_servicio',
        'id_tipo_proyecto',
        'id_prioridad'
    ];

    public function getLiderDeProyecto()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}