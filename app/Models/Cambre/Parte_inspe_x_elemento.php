<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Parte_inspe_x_elemento extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'parte_inspe_x_elemento';

    protected $primaryKey = 'id_parte_inspe_x_elemento';

    public $incrementing = true;

    protected $fillable = [ 
        'id_parte_inspe_x_elemento', 'id_parte_inspeccion', 'id_accion', 'ok', 'id_zona', 'id_zona_tarea'
    ];

     public function getParte()
    {
        return $this->belongsTo(Parte_inspeccion::class, 'id_parte_inspeccion', 'id_parte_inspeccion');
    }

    public function getZona()
    {
        return $this->belongsTo(Zona::class, 'id_zona', 'id_zona');
    }

    public function getZonaTarea()
    {
        return $this->belongsTo(Zona_tarea::class, 'id_zona_tarea', 'id_zona_tarea');
    }

    public function getAccionParaTarea()
    {
        return $this->belongsTo(Accion_para_tarea::class, 'id_accion', 'id_accion_tarea');
    }
}

