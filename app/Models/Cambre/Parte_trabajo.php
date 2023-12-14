<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Parte_trabajo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'parte_trabajo';

    protected $primaryKey = 'id_parte_trabajo';

    public $incrementing = true;

    protected $fillable = [ 
        'observacion',
        'fecha',
        'fecha_limite',
        'fecha_carga',
        'horas',
        'id_estado',
        'id_orden_trabajo',
        'id_responsabilidad'
    ];

    public function getEstado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function getResponsable()
    {
        return $this->belongsTo(Responsabilidad::class, 'id_responsabilidad');
    }
}