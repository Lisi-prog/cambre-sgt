<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Subtipo_servicio extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'subtipo_servicio';

    protected $primaryKey = 'id_subtipo_servicio';

    public $incrementing = false;

    protected $fillable = [ 
        'nombre_subtipo_servicio',
        'id_tipo_servicio'
    ];

    public function getSubTipos()
    {
        return $this->belongsTo(Tipo_servicio::class, 'id_tipo_servicio');
    }
}