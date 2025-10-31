<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Orden_manufactura extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'orden_manufactura';

    protected $primaryKey = 'id_orden_manufactura';

    public $incrementing = true;

    protected $fillable = [ 
        'revision',
        'cantidad',
        'ruta_plano',
        'id_orden'
    ];

    public function getOrden()
    {
        return $this->belongsTo(Orden::class, 'id_orden');
    }

    public function getOrdenesMecanizado(){
        return $this->hasMany(Orden_mecanizado::class, 'id_orden_manufactura');
    }

    public function getTipoOrden()
    {
        return 2;
    }

    public function getNombreTipoOrden(){
        return 'Manufactura';
    }

    public function getOrdenesMecanizadoRealizadas()
    {
        $ordenes = $this->getOrdenesMecanizado;
        $totalOrdenes = count($ordenes);
        $totalOrdenesFinalizados = $this->getOrdenesMecanizadofinalizadas();
        return $totalOrdenesFinalizados.'/'.$totalOrdenes;
    }

    public function getOrdenesMecanizadoRealizadasPorcentaje()
    {
        try {
            $ordenes = $this->getOrdenesMecanizado;
            $totalOrdenes = count($ordenes);
            $totalOrdenesFinalizados = $this->getOrdenesMecanizadofinalizadas();
            return ceil(($totalOrdenesFinalizados*100)/$totalOrdenes);
        } catch (\Throwable $th) {
            return '0';
        }
        
    }

    public function getOrdenesRealizadasPorcentaje()
    {
        $etapas = $this->getEtapas;
        $totalOrdenes = 0;
        $totalOrdenesFinalizados = 0;

        try {
            foreach ($etapas as $etapa) {
                $totalOrdenes += $etapa->getTotalOrdenes();
                $totalOrdenesFinalizados += $etapa->getOrdenesFinalizadas();
            }
            return ceil(($totalOrdenesFinalizados*100)/$totalOrdenes);
        } catch (\Throwable $th) {
            return '0';
        }
        
        // return ceil(($totalOrdenesFinalizados*100)/$totalOrdenes);
    }

    public function getOrdenesMecanizadofinalizadas(){
        $ordenes = $this->getOrdenesMecanizado;
        $totalOrdenesFinalizadas = 0;
        foreach ($ordenes as $orden_mec) {
           if ($orden_mec->getOrden->getFinalizado() == 1) {
                $totalOrdenesFinalizadas +=1;
           }

        }
        return $totalOrdenesFinalizadas;
    }

    public function getOrdenManuAsoc(){
        $ordManAsc = Orden_manufactura_asoc::where('id_orden_manufactura', $this->id_orden_manufactura)->first();
        if ($ordManAsc) {
            return $ordManAsc->id_orden_man_asoc;
        } else {
            return null;
        }
    }
}