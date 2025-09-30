<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\HoraMinutoCast;

class Vw_hoja_de_ruta extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'vw_hoja_de_ruta';

    protected $primaryKey = 'id_hoja_de_ruta';

    public $incrementing = false;

    protected $fillable = [ 
        'id_orden_mecanizado',
        'id_ope_de_hdr',
        'id_estado_hdr',
        'nombre_estado_hdr'
    ];

}