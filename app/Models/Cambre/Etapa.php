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

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_etapa',
        'descripcion_etapa',
        'fecha_inicio',
        'id_servicio',
        'id_responsabilidad'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}