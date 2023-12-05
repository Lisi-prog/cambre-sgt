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

    public $incrementing = false;

    protected $fillable = [ 
        'descripcion',
        'id_responsabilidad'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}