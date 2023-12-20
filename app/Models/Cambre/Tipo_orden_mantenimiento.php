<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tipo_orden_mantenimiento extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tipo_orden_mantenimiento';

    protected $primaryKey = 'id_tipo_orden_mantenimiento';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_tipo_orden_mantenimiento',
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}