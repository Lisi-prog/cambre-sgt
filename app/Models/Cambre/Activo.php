<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Activo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'activo';

    protected $primaryKey = 'id_activo';

    public $incrementing = true;

    protected $fillable = [ 
        'codigo_activo',
        'nombre_activo',
        'descripcion_activo',
        'esta_activo'
    ];

    public function getServicioDeMantenimiento()
    {
        return $this->hasMany(Servicio_de_mantenimiento::class, 'id_activo');
    }

    public function getServicioDeIngenieria()
    {
        return $this->hasMany(Servicio_de_ingenieria::class, 'id_activo');
    }

    public function getPropuestaDeMejora()
    {
        return $this->hasMany(Propuesta_de_mejora::class, 'id_activo');
    }
}