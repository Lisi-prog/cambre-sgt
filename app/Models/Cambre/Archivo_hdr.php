<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Archivo_hdr extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'archivo_hdr';

    protected $primaryKey = 'id_archivo_hdr';

    public $incrementing = true;

    protected $fillable = [ 
        'id_hoja_de_ruta',
        'nombre_archivo',
        'ruta'
    ];

    public function getHojaDeRuta()
    {
        return $this->belongsTo(Hoja_de_ruta::class, 'id_hoja_de_ruta');
    }
}