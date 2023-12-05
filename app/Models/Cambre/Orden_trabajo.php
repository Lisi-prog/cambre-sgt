<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Orden_trabajo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'orden_trabajo';

    protected $primaryKey = 'id_orden_trabajo';

    public $incrementing = false;

    protected $fillable = [ 
        'nombre_orden_trabajo',
        'id_estado',
        'id_etapa',
        'id_responsabilidad'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}