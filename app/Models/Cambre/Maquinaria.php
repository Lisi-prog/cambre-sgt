<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Maquinaria extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'maquinaria';

    protected $primaryKey = 'id_maquinaria';

    public $incrementing = true;

    protected $fillable = [ 
        'codigo_maquinaria',
        'alias_maquinaria'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}