<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Orden_manufactura extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'orden_manufactura';

    protected $primaryKey = 'id_orden_manufactura';

    public $incrementing = true;

    protected $fillable = [ 
        'revision',
        'cantidad',
        'fecha_inicio',
        'fecha_requerida',
        'ruta_plano',
        'observaciones',
        'id_estado',
        'id_etapa',
        'id_responsabilidad'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }

    public function getTipoOrden()
    {
        return 'Manufactura';
    }
}