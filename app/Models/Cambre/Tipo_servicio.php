<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tipo_servicio extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tipo_servicio';

    protected $primaryKey = 'id_tipo_servicio';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_tipo_servicio',
    ];

    public function getSubTipos()
    {
        return $this->hasMany(Subtipo_servicio::class, 'id_tipo_servicio');
    }

    public function getSolicitudes()
    {
        return $this->hasMany(Solicitud::class, 'id_tipo_servicio');
    }
}