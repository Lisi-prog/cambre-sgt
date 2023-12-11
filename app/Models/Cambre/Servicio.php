<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Servicio extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'servicio';

    protected $primaryKey = 'id_servicio';

    public $incrementing = true;

    protected $fillable = [ 
        'codigo_servicio',
        'nombre_servicio',
        'fecha_inicio',
        'fecha_limite',
        'id_responsabilidad',
        'id_tipo_servicio',
        'id_prioridad'
    ];

    public function getTipoServicio()
    {
        return $this->belongsTo(Tipo_servicio::class, 'id_tipo_servicio');
    }

    public function getResponsabilidad()
    {
        return $this->belongsTo(Responsabilidad::class, 'id_responsabilidad');
    }

    public function getPrioridad()
    {
        return $this->belongsTo(Prioridad::class, 'id_prioridad');
    }
}