<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Responsabilidad extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'responsabilidad';

    protected $primaryKey = 'id_responsabilidad';

    public $incrementing = true;

    protected $fillable = [ 
        'id_empleado',
        'id_rol_empleado'
    ];

    public function getServicios()
    {
        return $this->hasMany(Servicio::class, 'id_responsabilidad');
    }

    public function getEmpleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function getRol()
    {
        return $this->belongsTo(Rol_empleado::class, 'id_rol_empleado');
    }

    public function getResponsabilidadOrden(){  
        return $this->hasOne(Responsabilidad_orden::class, 'id_responsabilidad');
    }
}