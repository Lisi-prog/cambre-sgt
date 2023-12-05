<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Prioridad_solicitud extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'prioridad_solicitud';

    protected $primaryKey = 'id_prioridad_solicitud';

    public $incrementing = false;

    protected $fillable = [ 
        'nombre_prioridad_solicitud'
    ];

    public function getSolicitud()
    {
        return $this->hasMany(Solicitud::class, 'id_prioridad_solicitud');
    }
}