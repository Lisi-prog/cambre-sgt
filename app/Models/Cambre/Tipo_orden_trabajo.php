<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tipo_orden_trabajo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tipo_orden_trabajo';

    protected $primaryKey = 'id_tipo_orden_trabajo';

    public $incrementing = false;

    protected $fillable = [ 
        'nombre_tipo_orden_trabajo',
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}