<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Parte_manufactura extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'parte_manufactura';

    protected $primaryKey = 'id_parte_manufactura';

    public $incrementing = true;

    protected $fillable = [ 
        'id_parte',
        'id_estado_manufactura',
        'id_responsabilidad'
    ];

    public function getEstadoManufactura()
    {
        return $this->belongsTo(Estado_manufactura::class, 'id_estado_manufactura');
    }

    public function getResponsable()
    {
        return $this->belongsTo(Responsabilidad::class, 'id_responsabilidad');
    }

    public function getParte()
    {
        return $this->belongsTo(Parte::class, 'id_parte');
    }
}