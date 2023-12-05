<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Etapa extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'etapa';

    protected $primaryKey = 'id_etapa';

    public $incrementing = false;

    protected $fillable = [ 
        'nombre_etapa',
        'descripcion_etapa',
        'fecha_inicio',
        'fecha_limite',
        'id_proyecto',
        'id_responsabilidad',
        'id_estado',
        'id_tipo_etapa',
        'id_actualizacion'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}