<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Orden_mantenimiento extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'orden_mantenimiento';

    protected $primaryKey = 'id_orden_mantenimiento';

    public $incrementing = true;

    protected $fillable = [ 
        'id_tipo_orden_mantenimiento',
        'id_orden'
    ];

    public function getOrden()
    {
        return $this->belongsTo(Orden::class, 'id_orden');
    }

    public function getTipoOrdenMantenimiento()
    {
        return $this->belongsTo(Tipo_orden_mantenimiento::class, 'id_tipo_orden_mantenimiento');
    }

    public function getNombreTipoOrden()
    {
        return 'Mantenimiento';
    }

    public function getPartes()
    {
        return $this->hasMany(Parte::class, 'id_orden', 'id_orden');
    }

    public function getEstadoActual(){
        return $this->getPartes->sortByDesc('id_parte')->first()->getParteDe->getEstado->nombre_estado_mantenimiento;
    }

    public function getTipoOrden()
    {
        return 4;
    }
}