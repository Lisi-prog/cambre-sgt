<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Servicio_de_ingenieria extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'servicio_de_ingenieria';

    protected $primaryKey = 'id_servicio_de_ingenieria';

    public $incrementing = false;

    protected $fillable = [ 
        'id_solicitud',
        'id_empleado',
        'id_sector',
        'id_activo'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}