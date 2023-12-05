<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Servicio_requerido extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'servicio_requerido';

    protected $primaryKey = 'id_servicio_requerido';

    public $incrementing = false;

    protected $fillable = [ 
        'nombre_servicio_requerido'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}