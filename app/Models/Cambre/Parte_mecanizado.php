<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class parte_mecanizado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'parte_mecanizado';

    protected $primaryKey = 'id_parte_mecanizado';

    public $incrementing = true;

    protected $fillable = [ 
        'observacion',
        'fecha',
        'fecha_limite',
        'fecha_carga',
        'horas',
        'horas_maquina',
        'id_estado',
        'id_orden_mecanizado',
        'id_responsabilidad',
        'id_maquinaria'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}