<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Orden_manufactura extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'orden_manufactura';

    protected $primaryKey = 'id_orden_manufactura';

    public $incrementing = true;

    protected $fillable = [ 
        'revision',
        'cantidad',
        'ruta_plano',
        'id_orden'
    ];

    public function getOrden()
    {
        return $this->belongsTo(Orden::class, 'id_orden');
    }

    public function getTipoOrden()
    {
        return 2;
    }
    public function getNombreTipoOrden(){
        return 'Manufactura';
    }
}