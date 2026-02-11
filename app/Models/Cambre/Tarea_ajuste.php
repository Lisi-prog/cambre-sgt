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
        'id_parte_ajuste', 'id_accion_tarea', 'id_zona', 'id_maquinaria', 'hecho'
    ];

    public function getParteAjuste()
    {
        return $this->belongsTo(Parte_ajuste::class, 'id_parte_ajuste');
    }   

}