<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Operaciones_de_hdr extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'operaciones_de_hdr';

    protected $primaryKey = 'id_ope_de_hdr';

    public $incrementing = true;

    protected $fillable = [ 
        'id_hoja_de_ruta',
        'numero',
        'fecha_carga',
        'fecha',
        'id_maquinaria',
        'id_operacion',
        'id_responsabilidad',
        'medidas',
        'ruta_cam'
    ];

    // public function getEstado(){
    //     return Parte_ope_hdr::where('id_ope_de_hdr', $this->id_ope_de_hdr)->orderBy('')->first()->estado_mecanizado;
    // }
}