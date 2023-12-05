<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Orden_mecanizado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'orden_mecanizado';

    protected $primaryKey = 'id_orden_mecanizado';

    public $incrementing = false;

    protected $fillable = [ 
        'revision',
        'cantidad',
        'fecha_inicio',
        'fecha_requerida',
        'ruta_plano',
        'observaciones',
        'id_prioridad',
        'id_estado_mecanizado',
        'id_orden_manufactura',
        'id_responsabilidad'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}