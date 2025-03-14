<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Hoja_de_ruta extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'hoja_de_ruta';

    protected $primaryKey = 'id_hoja_de_ruta';

    public $incrementing = true;

    protected $fillable = [ 
        'fecha_carga',
        'observaciones',
        'id_responsabilidad',
        'id_orden_mecanizado',
        'ruta'
    ];

    public function getOperacionesHdr()
    {
        return $this->hasMany(Operaciones_de_hdr::class, 'id_hoja_de_ruta');
    }

    public function getUltOpeActiva(){
        return Operaciones_de_hdr::where('id_hoja_de_ruta', $this->id_hoja_de_ruta)->where('activo', 1)->first()->getOperacion->nombre_operacion;
    }
    // public function getEstado()
    // {
    //     return 
    // }
}