<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Orden_trabajo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'orden_trabajo';

    protected $primaryKey = 'id_orden_trabajo';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_orden_trabajo',
        'duracion_estimada',
        'id_tipo_orden_trabajo',
        'id_etapa',
        'id_responsabilidad'
    ];

    public function getEtapa()
    {
        return $this->belongsTo(Etapa::class, 'id_etapa');
    }

    public function getPartes()
    {
        return $this->hasMany(Parte_trabajo::class, 'id_orden_trabajo');
    }

    public function getTipoOrdenTrabajo()
    {
        return $this->belongsTo(Tipo_orden_trabajo::class, 'id_tipo_orden_trabajo');
    }
    
    public function getResponsable()
    {
        return $this->belongsTo(Responsabilidad::class, 'id_responsabilidad');
    }
//Estas dos funciones probablemente se podrian unir en una sola que devuelva un objeto con ambas propiedades
//pero me parece que asi es mas comodo 
    public function getTipoOrden()
    {
        return 1;
    }
    public function getNombreTipoOrden(){
        return 'Trabajo';
    }
}