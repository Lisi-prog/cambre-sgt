<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Orden_mecanizado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'orden_mecanizado';

    protected $primaryKey = 'id_orden_mecanizado';

    public $incrementing = true;

    protected $fillable = [ 
        'revision',
        'cantidad',
        'ruta_pieza',
        'id_orden',
        'id_orden_manufactura',
        'id_orden_mec_asoc',
        'id_orden_trab_compar'
    ];

    public function getOrden()
    {
        return $this->belongsTo(Orden::class, 'id_orden');
    }

    public function getOrdenManufactura()
    {
        return $this->belongsTo(Orden_manufactura::class, 'id_orden_manufactura');
    }

    public function getPartes()
    {
        return $this->hasMany(Parte_mecanizado::class, 'id_orden_mecanizado');
    }

    public function getTipoOrden()
    {
        return 3;
    }
    public function getNombreTipoOrden(){
        return 'Mecanizado';
    }

    public function getHdrActivo(){
        return $hojasDeRuta = HojaDeRuta::where('id_orden_mecanizado', $this->id_orden_mecanizado)->whereHas('getOperacionesHdr', function ($query) {
            $query->where('activo', 1);
        })->first();
    }

    public function getHdr(){
        return $this->hasMany(Hoja_de_ruta::class, 'id_orden_mecanizado');
    }
}