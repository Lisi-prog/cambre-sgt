<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Parte_ajuste extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'parte_ajuste';

    protected $primaryKey = 'id_parte_ajuste';

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

    public function getTareasAjuste(){
        return $this->hasMany(Tarea_ajuste::class, 'id_parte_ajuste', 'id_parte_ajuste');
    }

}

