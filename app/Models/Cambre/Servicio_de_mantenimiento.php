<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Servicio_de_mantenimiento extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'servicio_de_mantenimiento';

    protected $primaryKey = 'id_servicio_de_mantenimiento';

    public $incrementing = true;

    protected $fillable = [ 
        'id_solicitud',
        'id_servicio_requerido',
        'id_activo'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}