<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Actualizacion_servicio extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'actualizacion_servicio';

    protected $primaryKey = 'id_actualizacion_servicio';

    public $incrementing = true;

    protected $fillable = [ 
        'id_actualizacion',
        'id_servicio'
    ];

    public function getActualizacion()
    {
        return $this->belongsTo(Actualizacion::class, 'id_actualizacion');
    }

    public function getServicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }
}