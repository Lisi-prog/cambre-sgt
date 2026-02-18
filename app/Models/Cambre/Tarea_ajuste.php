<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tarea_ajuste extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tarea_ajuste';

    protected $primaryKey = 'id_tarea_ajuste';

    public $incrementing = true;

    protected $fillable = [ 
        'id_parte_ajuste', 'id_accion_tarea', 'id_zona', 'id_maquinaria', 'hecho', 'id_tarea_mantenimiento'
    ];

    public function getParteAjuste()
    {
        return $this->belongsTo(Parte_ajuste::class, 'id_parte_ajuste');
    }   

    public function getAccionTarea(){
        return $this->hasOne(Accion_para_tarea::class, 'id_accion_tarea', 'id_accion_tarea');
    }
    
    public function getZona(){
        return $this->hasOne(Zona::class, 'id_zona', 'id_zona');
    }    

    public function getMaquinaria(){
        return $this->hasOne(Maquinaria::class, 'id_maquinaria', 'id_maquinaria');
    }

    public function getTareaMantenimiento(){
        return $this->hasOne(Tarea_mantenimiento::class, 'id_tarea_mantenimiento', 'id_tarea_mantenimiento');
    }
}