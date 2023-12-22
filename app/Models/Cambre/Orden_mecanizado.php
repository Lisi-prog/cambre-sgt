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
        'id_orden'
    ];

    public function getOrden()
    {
        return $this->belongsTo(Orden::class, 'id_orden');
    }

    public function getTipoOrden()
    {
        return 'Mecanizado';
    }
}