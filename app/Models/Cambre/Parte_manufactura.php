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
        'id_estado_manufactura'
    ];

    public function getEstadoManufactura()
    {
        return $this->belongsTo(Estado_manufactura::class, 'id_estado_manufactura');
    }

    public function getParte()
    {
        return $this->belongsTo(Parte::class, 'id_parte');
    }

    public function getNombreEstado(){
        return Estado_manufactura::where('id_estado_manufactura', $this->id_estado_manufactura)->first()->nombre_estado_manufactura;
    }

    public function getFinalizado()
    {
        if ($this->id_estado_manufactura == 5) {
            return 1;
        }
        return 0;
    }
}