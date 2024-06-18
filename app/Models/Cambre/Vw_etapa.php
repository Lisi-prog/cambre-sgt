<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_etapa extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'vw_etapa';

    protected $primaryKey = 'id_etapa';

    public $incrementing = false;

    protected $fillable = [ 
        'id_etapa',
        'id_servicio',
        'descripcion_etapa',
        'fecha_inicio',
        'id_estado',
        'nombre_estado',
        'id_responsable',
        'responsable',
        'fecha_limite',
        'fecha_ult_act',
        'fecha_finalizacion',
        'costo_real',
        'costo_etimado'
    ];

}