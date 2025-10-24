<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Hoja_de_ruta extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'hoja_de_ruta';

    protected $primaryKey = 'id_hoja_de_ruta';

    public $incrementing = true;

    protected $fillable = [ 
        'fecha_carga',
        'observaciones',
        'ubicacion',
        'cantidad',
        'id_responsabilidad',
        'id_orden_mecanizado',
        'ruta',
        'activo'
    ];

    public function getOperacionesHdr()
    {
        return $this->hasMany(Operaciones_de_hdr::class, 'id_hoja_de_ruta');
    }

    public function getVistaOperacionesHdr(){
        return $this->hasMany(Vw_operaciones_de_hdr::class, 'id_hoja_de_ruta');
    }

    public function getUltOpeActiva(){
        $ope_act = Operaciones_de_hdr::where('id_hoja_de_ruta', $this->id_hoja_de_ruta)->where('activo', 1)->first();
        if ($ope_act) {
            return $ope_act->getOperacion->nombre_operacion;
        } else {
            return '-';
        }
        
        // return Operaciones_de_hdr::where('id_hoja_de_ruta', $this->id_hoja_de_ruta)->where('activo', 1)->first()->getOperacion->nombre_operacion;
    }
    // public function getEstado()
    // {
    //     return 
    // }

    public function getFechaCargaAttribute($value)
     {
         return Carbon::parse($value)->format('Y-m-d'); // Formato: 10-05-2024
     }

     public function getOrdMec(){
        return $this->belongsTo(Orden_mecanizado::class, 'id_orden_mecanizado');
     }

     public function getTotalOpe(){
        return Operaciones_de_hdr::where('id_hoja_de_ruta', $this->id_hoja_de_ruta)->count();
     }

     public function getTotalOpeCompleto(){
        // return Operaciones_de_hdr::where('id_hoja_de_ruta', $this->id_hoja_de_ruta)->count();
        $ops = Operaciones_de_hdr::where('id_hoja_de_ruta', $this->id_hoja_de_ruta)->get();
        $totalOpeFinalizadas = 0;

        foreach ($ops as $op) {

           if ($op->getFinalizado() == 1) {
                $totalOpeFinalizadas +=1;
           }

        }

        return $totalOpeFinalizadas;
     }

     public function getProgreso(){
        $ops = Operaciones_de_hdr::where('id_hoja_de_ruta', $this->id_hoja_de_ruta)->get();
        $progreso = 0;
        
        try {
            $total = 100 / count($ops);
            foreach ($ops as $op) {
                if ($op->getFinalizado() == 1) {
                     $progreso += $total;
                } ;
             }
        } catch (\Throwable $th) {
            $total = 0;
        }

        return $progreso;     
    }

    public function getEstadoActual(){
        $ope_act = Operaciones_de_hdr::where('id_hoja_de_ruta', $this->id_hoja_de_ruta)->where('activo', 1)->first();
        if ($ope_act) {
            return $ope_act->getEstado();
        } else {
            $ult_op = Operaciones_de_hdr::where('id_hoja_de_ruta', $this->id_hoja_de_ruta)->orderBy('id_ope_de_hdr', 'desc')->first();
            if ($ult_op) {
                return $ult_op->getEstado();
            } else {
                return '-';
            }
        }
    }

    public function getIdEstadoActual(){
        $ope_act = Operaciones_de_hdr::where('id_hoja_de_ruta', $this->id_hoja_de_ruta)->where('activo', 1)->first();
        if ($ope_act) {
            return $ope_act->getIdEstado();
        } else {
            $ult_op = Operaciones_de_hdr::where('id_hoja_de_ruta', $this->id_hoja_de_ruta)->orderBy('id_ope_de_hdr', 'desc')->first();
            if ($ult_op) {
                return $ult_op->getIdEstado();
            } else {
                return '-';
            }
        }
    }

    public function getEstaActivo(){
        $ope_activa = Operaciones_de_hdr::where('id_hoja_de_ruta', $this->id_hoja_de_ruta)->where('activo', 1)->first();
        if ($ope_activa) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getResponsable()
    {
        return $this->belongsTo(Responsabilidad::class, 'id_responsabilidad');
    }
}