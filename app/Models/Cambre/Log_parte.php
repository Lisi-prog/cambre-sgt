<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Log_parte extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'log_parte';

    protected $primaryKey = 'id_log_parte';

    public $incrementing = true;

    protected $fillable = [ 
        'id_parte',
        'id_responsabilidad',
        'observaciones',
        'fecha',
        'fecha_limite',
        'horas',
        'estado',
        'id_maquinaria',
        'horas_maquina',
        'responsable_cambio'
    ];

    public function getParte()
    {
        return $this->belongsTo(Parte::class, 'id_parte');
    }
}