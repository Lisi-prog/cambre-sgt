<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Parte_ope_hdr extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'parte_ope_hdr';

    protected $primaryKey = 'id_parte_ope_hdr';

    public $incrementing = true;

    protected $fillable = [ 
        'id_ope_de_hdr',
        'fecha_carga',
        'fecha',
        'observaciones',
        'id_responsabilidad',
        'horas',
        'id_estado_hdr',
        'medidas'
    ];

    public function getEstado(){
        return $this->hasOne(Estado_hdr::class, 'id_estado_hdr');
    }

    public function getNombreEstado(){
        return Estado_hdr::where('id_estado_hdr', $this->id_estado_hdr)->first()->nombre_estado_hdr;
    }
}