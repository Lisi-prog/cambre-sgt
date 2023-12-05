<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Parte_trabajo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'parte_trabajo';

    protected $primaryKey = 'id_parte_trabajo';

    public $incrementing = false;

    protected $fillable = [ 
        'observacion',
        'fecha',
        'fecha_limite',
        'fecha_carga',
        'horas',
        'id_estado',
        'id_orden_trabajo',
        'id_responsabilidad'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}