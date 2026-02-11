<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Parte_inspe_x_tarea_mant extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'parte_inspe_x_tarea_mant';

    protected $primaryKey = 'id_parte_inspe_x_tarea_mant';

    public $incrementing = true;

    protected $fillable = [ 
        'id_parte_inspeccion', 'id_tarea_mantenimiento', 'id_accion', 'ok'
    ];

    public function getParte()
    {
        return $this->belongsTo(Parte_inspeccion::class, 'id_parte_inspeccion', 'id_parte_inspeccion');
    }

    public function getTareaMantenimiento()
    {
        return $this->belongsTo(Tarea_mantenimiento::class, 'id_tarea_mantenimiento', 'id_tarea_mantenimiento');
    }

    public function getAccionParaTarea()
    {
        return $this->belongsTo(Accion_para_tarea::class, 'id_accion', 'id_accion_tarea');
    }

}

