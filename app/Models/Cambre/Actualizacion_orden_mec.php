<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Actualizacion_orden_mec extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'actualizacion_orden_mec';

    protected $primaryKey = 'id_actualizacion_orden_mec';

    public $incrementing = true;

    protected $fillable = [ 
        'id_actualizacion_orden',
        'id_orden_mecanizado',
        'id_estado_mecanizado'
    ];

    public function getActualizacion()
    {
        return $this->belongsTo(Actualizacion_orden::class, 'id_actualizacion_orden');
    }

    public function getOrden()
    {
        return $this->belongsTo(Orden_manufactura::class, 'id_orden_manufactura');
    }
}