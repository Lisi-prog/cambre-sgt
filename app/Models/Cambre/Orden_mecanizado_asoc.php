<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Orden_mecanizado_asoc extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'orden_mecanizado_asoc';

    // protected $primaryKey = 'id_orden_manufactura';

    public $incrementing = true;

    protected $fillable = [ 
        'id_orden_mecanizado',
        'id_orden_mec_asoc',
        'ord_tra_compar'
    ];

}