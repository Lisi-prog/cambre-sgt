<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sol_propuesta_de_mejora extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'sol_propuesta_de_mejora';

    protected $primaryKey = 'id_propuesta_de_mejora';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_emisor',
        'id_solicitud',
        'id_responsabilidad',
        'id_sector',
        'id_activo',
        'titulo_propuesta',
        'objetivo_propuesta',
        'descripcion_propuesta',
        'analisis_propuesta',
        'beneficio_propuesta',
        'problema_propuesta',
        'evaluacion_propuesta'
    ];

    public function getSolicitud()
    {
        return $this->belongsTo(Sol_solicitud::class, 'id_solicitud');
    }
    
    public function getEmpleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function getResponsabilidad()
    {
        return $this->belongsTo(Responsabilidad::class, 'id_responsabilidad');
    }

    public function getSector()
    {
        return $this->belongsTo(Sector::class, 'id_sector');
    }

    public function getActivo()
    {
        return $this->belongsTo(Activo::class, 'id_activo');
    }
}