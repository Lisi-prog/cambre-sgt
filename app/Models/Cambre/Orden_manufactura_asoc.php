<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Orden_manufactura_asoc extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'orden_manufactura_asoc';

    // protected $primaryKey = 'id_orden_manufactura';

    public $incrementing = true;

    protected $fillable = [ 
        'id_orden_manufactura',
        'id_orden_man_asoc',
        'es_retrabajo'
    ];

    public function getOrdenManufactura()
    {
        return $this->hasOne(Orden_manufactura::class, 'id_orden_manufactura', 'id_orden_man_asoc');
    }
}