<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Responsabilidad extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'responsabilidad';

    protected $primaryKey = 'id_responsabilidad';

    public $incrementing = false;

    protected $fillable = [ 
        'id_empleado',
        'id_rol_empleado'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}