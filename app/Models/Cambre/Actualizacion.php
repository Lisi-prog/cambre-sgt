<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Actualizacion extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'actualizacion';

    protected $primaryKey = 'id_actualizacion';

    public $incrementing = true;

    protected $fillable = [ 
        'descripcion',
        'fecha_limite',
        'id_estado',
        'id_responsabilidad'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}