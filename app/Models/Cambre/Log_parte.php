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
        'fecha_carga',
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

    public function getResponsabilidad()
    {
        return Responsabilidad::where('id_responsabilidad', $this->id_responsabilidad)->first();
    }

    public function getNombreResponsable(){
        return $this->getResponsabilidad()->getEmpleado->nombre_empleado;
    }

    public function getNombreEditor(){
        return Empleado::where('id_empleado', $this->responsable_cambio)->first()->nombre_empleado;
    }
}