<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Propuesta_de_mejora extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'propuesta_de_mejora';

    protected $primaryKey = 'id_propuesta_de_mejora';

    public $incrementing = true;

    protected $fillable = [ 
        'id_empleado',
        'id_responsabilidad',
        'id_sector',
        'id_activo',
        'titulo_propuesta',
        'objetivo_propuesta',
        'descripcion_propuesta',
        'analisis_propuesta',
        'beneficio_propuesta',
        'problema_propuesta',
        'evaluacion_propuesta',
        'fecha_carga'
    ];

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

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}