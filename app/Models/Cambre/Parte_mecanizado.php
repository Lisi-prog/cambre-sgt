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
        'id_estado_mecanizado',
        'id_orden_mecanizado',
        'id_responsabilidad'
    ];

    public function getEstadoMecanizado()
    {
        return $this->belongsTo(Estado_mecanizado::class, 'id_estado_mecanizado');
    }

    public function getResponsable()
    {
        return $this->belongsTo(Responsabilidad::class, 'id_responsabilidad');
    }

    public function getOrden()
    {
        return $this->belongsTo(Orden_mecanizado::class, 'id_orden_mecanizado');
    }
}