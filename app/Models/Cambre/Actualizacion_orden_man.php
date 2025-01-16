<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Actualizacion_orden_man extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'actualizacion_orden_man';

    protected $primaryKey = 'id_actualizacion_orden_man';

    public $incrementing = true;

    protected $fillable = [ 
        'id_actualizacion_orden',
        'id_orden_manufactura',
        'id_estado_manufactura'
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