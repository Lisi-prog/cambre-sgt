<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Parte_inspeccion extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'parte_inspeccion';

    protected $primaryKey = 'id_parte_inspeccion';

    public $incrementing = true;

    protected $fillable = [ 
        'id_parte', 'id_estado_mantenimiento'
    ];

    public function getParte()
    {
        return $this->belongsTo(Parte::class, 'id_parte', 'id_parte');
    }

    public function getEstado()
    {
        return $this->belongsTo(Estado_mantenimiento::class, 'id_estado_mantenimiento', 'id_estado_mantenimiento');
    }

    public function getTareasMantenimiento()
    {
        return $this->hasMany(Parte_inspe_x_tarea_mant::class, 'id_parte_inspeccion', 'id_parte_inspeccion');
    }

    public function getParteInspeXTareasMantenimiento(){
        return $this->hasMany(Parte_inspe_x_tarea_mant::class, 'id_parte_inspeccion', 'id_parte_inspeccion');
    }
    
}

