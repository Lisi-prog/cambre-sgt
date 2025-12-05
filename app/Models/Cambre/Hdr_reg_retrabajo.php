<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Hdr_reg_retrabajo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'hdr_reg_retrabajo';

    protected $primaryKey = 'id_hdr_reg_retrabajo';

    // public $incrementing = false;

    protected $fillable = [ 
        'id_hoja_de_ruta',
        'fecha_carga',
        'numero',
        'observaciones',
        'id_empleado'
    ];

}