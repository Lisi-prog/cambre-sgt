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
        'prioridad',
        'fecha_carga',
        'fecha',
        'id_maquinaria',
        'id_operacion',
        'ruta_cam',
        'activo'
    ];

    public function getPartes()
    {
        return $this->hasMany(Parte_ope_hdr::class, 'id_ope_de_hdr');
    }

    public function getEstado()
    {
        return $this->getPartes->sortByDesc('id_parte_ope_hdr')->first()->getNombreEstado();
    }

    public function getOperacion(){
        return $this->belongsTo(Operacion::class, 'id_operacion');
    }

    public function getMaquinaria(){
        return $this->belongsTo(Maquinaria::class, 'id_maquinaria');
    }

    public function getAsignado(){
        if (Parte_ope_hdr::where('id_ope_de_hdr', $this->id_ope_de_hdr)->orderBy('id_parte_ope_hdr')->first()->getResponsable) {
            return Parte_ope_hdr::where('id_ope_de_hdr', $this->id_ope_de_hdr)->orderBy('id_parte_ope_hdr')->first()->getResponsable->getEmpleado->nombre_empleado;
        } else {
            return "";
        }
        
        
    }

    public function getHdr(){
        return $this->belongsTo(Hoja_de_ruta::class, 'id_hoja_de_ruta');
    }

    public function getFinalizado()
    {   
        return $this->getPartes->sortByDesc('id_parte_ope_hdr')->first()->getFinalizado();
    }

    public function getIdEstado()
    {
        return $this->getPartes->sortByDesc('id_parte_ope_hdr')->first()->id_estado_hdr;
    }
}