<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Actualizacion_orden extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'actualizacion_orden';

    protected $primaryKey = 'id_actualizacion_orden';

    public $incrementing = true;

    protected $fillable = [ 
        'descripcion',
        'fecha_limite',
        'fecha_carga',
        'id_responsabilidad'
    ];

    public function getResponsable()
    {
        return $this->belongsTo(Responsabilidad::class, 'id_responsabilidad');
    }
}