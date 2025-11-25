<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Hdr_reg_fallo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'hdr_reg_fallo';

    // protected $primaryKey = 'id_hoja_de_ruta';

    public $incrementing = false;

    protected $fillable = [ 
        'id_hdr_ant',
        'id_hdr_sig',
        'observaciones_fallo',
        'responsable_fallo',
        'id_empleado'
    ];

}