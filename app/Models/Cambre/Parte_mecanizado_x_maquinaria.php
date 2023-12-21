<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class parte_mecanizado_x_maquinaria extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'parte_mecanizado_x_maquinaria';

    protected $primaryKey = 'id_parte_mecanizado_x_maquinaria';

    public $incrementing = true;

    protected $fillable = [ 
        'id_parte_mecanizado',
        'id_maquinaria',
        'horas_maquina'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}