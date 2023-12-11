<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Rol_empleado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'rol_empleado';

    protected $primaryKey = 'id_rol_empleado';

    public $incrementing = false;

    protected $fillable = [ 
        'nombre_rol_empleado'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}