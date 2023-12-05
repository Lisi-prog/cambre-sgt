<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tipo_servicio extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tipo_servicio';

    protected $primaryKey = 'id_tipo_servicio';

    public $incrementing = false;

    protected $fillable = [ 
        'nombre_tipo_servicio',
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}