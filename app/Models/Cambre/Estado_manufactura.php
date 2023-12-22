<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Estado_manufactura extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'estado_manufactura';

    protected $primaryKey = 'id_estado_manufactura';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_estado_manufactura',
    ];

    public function getOrdenManufactura()
    {
        return $this->hasMany(Orden_manufactura::class, 'id_estado_manufactura');
    }
}