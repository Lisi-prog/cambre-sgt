<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Orden_mecanizado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'orden_mecanizado';

    protected $primaryKey = 'id_orden_mecanizado';

    public $incrementing = true;

    protected $fillable = [ 
        'revision',
        'cantidad',
        'fecha_inicio',
        'fecha_requerida',
        'ruta_plano',
        'observaciones',
        'duracion_estimada',
        'id_etapa',
        'id_responsabilidad'
    ];

    public function getEtapa()
    {
        return $this->belongsTo(Etapa::class, 'id_etapa');
    }

    public function getPartes()
    {
        return $this->hasMany(Parte_mecanizado::class, 'id_orden_mecanizado');
    }

    public function getResponsable()
    {
        return $this->belongsTo(Responsabilidad::class, 'id_responsabilidad');
    }

    public function getTipoOrden()
    {
        return 'Mecanizado';
    }
}