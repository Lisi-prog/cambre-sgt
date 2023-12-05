<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Empleado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'empleado';

    protected $primaryKey = 'id_empleado';

    public $incrementing = false;

    protected $fillable = [ 
        'nombre_empleado',
        'email_empleado',
        'telefono_empleado',
        'user_id'
    ];

    public function getRequerimientoIngenieria()
    {
        return $this->hasMany(Requerimiento_de_ingenieria::class, 'id_empleado');
    }

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}