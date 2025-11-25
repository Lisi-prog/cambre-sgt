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
        'activo',
        'id_orden_manufactura',
        'horas_estimada',
        'es_retrabajo',
        'tecnico_asignado'
    ];

    public function getPartes()
    {
        return $this->hasMany(Parte_ope_hdr::class, 'id_ope_de_hdr');
    }

    public function getTotaPartesActual(){
        return $this->getPartes()->count();
    }

    public function getMedidaEstado(){
        $esta_validado = Parte_ope_hdr::where('medidas', 1)->where('id_ope_de_hdr', $this->id_ope_de_hdr)->first();

        if ($esta_validado) {
            return 1;
        } else {
            return 0;
        }

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

    // public function getAsignado(){
    //     if (Parte_ope_hdr::where('id_ope_de_hdr', $this->id_ope_de_hdr)->orderBy('id_parte_ope_hdr')->first()->getResponsable) {
    //         return Parte_ope_hdr::where('id_ope_de_hdr', $this->id_ope_de_hdr)->orderBy('id_parte_ope_hdr')->first()->getResponsable->getEmpleado->nombre_empleado;
    //     } else {
    //         return "";
    //     }  
    // }

    public function getAsignado(){
        if ($this->tecnico_asignado) {
            return Empleado::where('id_empleado', $this->tecnico_asignado)->first()->nombre_empleado;
        } else {
            return "";
        }  
    }

    public function getTecnicoAsignado(){
        return $this->belongsTo(Empleado::class, 'tecnico_asignado', 'id_empleado'); 
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

    public function getOrdenManufactura()
    {
        return $this->belongsTo(Orden_manufactura::class, 'id_orden_manufactura', 'id_orden_manufactura');
    }

    public function getAsignadoOpeEnsa(){

        if (Parte_ope_hdr::where('id_ope_de_hdr', $this->id_ope_de_hdr)->where('observaciones', 'Se activo la operacion para el ensamblado de la orden de manufactura.')->first()) {
            if (Parte_ope_hdr::where('id_ope_de_hdr', $this->id_ope_de_hdr)->where('observaciones', 'Se activo la operacion para el ensamblado de la orden de manufactura.')->first()->getResponsable) {
                return Parte_ope_hdr::where('id_ope_de_hdr', $this->id_ope_de_hdr)->where('observaciones', 'Se activo la operacion para el ensamblado de la orden de manufactura.')->first()->getResponsable->getEmpleado->id_empleado;
            } else {
                return '';
            } 
        } else {
            return '';
        }
        
    }

    public function getNombreAsignadoOpeEnsa(){

        if (Parte_ope_hdr::where('id_ope_de_hdr', $this->id_ope_de_hdr)->where('observaciones', 'Se activo la operacion para el ensamblado de la orden de manufactura.')->first()) {
            if (Parte_ope_hdr::where('id_ope_de_hdr', $this->id_ope_de_hdr)->where('observaciones', 'Se activo la operacion para el ensamblado de la orden de manufactura.')->first()->getResponsable) {
                return Parte_ope_hdr::where('id_ope_de_hdr', $this->id_ope_de_hdr)->where('observaciones', 'Se activo la operacion para el ensamblado de la orden de manufactura.')->first()->getResponsable->getEmpleado->nombre_empleado;
            } else {
                return '';
            } 
        } else {
            return '';
        }
    }
}