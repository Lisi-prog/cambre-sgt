<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Actualizacion_etapa extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'actualizacion_etapa';

    protected $primaryKey = 'id_actualizacion_etapa';

    public $incrementing = true;

    protected $fillable = [ 
        'id_actualizacion',
        'id_etapa'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }

    public function getActualizacion()
    {
        return $this->belongsTo(Actualizacion::class, 'id_actualizacion');
    }
}