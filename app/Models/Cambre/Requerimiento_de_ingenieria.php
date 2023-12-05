<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Requerimiento_de_ingenieria extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'requerimiento_de_ingenieria';

    protected $primaryKey = 'id_requerimiento_de_ingenieria';

    public $incrementing = true;

    protected $fillable = [ 
        'id_solicitud',
        'id_empleado',
        'id_sector'
    ];

    public function getSolicitud()
    {
        return $this->hasOne(Solicitud::class, 'id_solicitud');
    }

    public function getEmpleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function getSector()
    {
        return $this->belongsTo(Sector::class, 'id_sector');
    }
}