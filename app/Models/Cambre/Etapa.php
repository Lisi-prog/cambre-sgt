<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Etapa extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'etapa';

    protected $primaryKey = 'id_etapa';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_etapa',
        'descripcion_etapa',
        'fecha_inicio',
        'id_servicio',
        'id_responsabilidad'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }

    public function getServicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }

    public function getActualizaciones()
    {
        return $this->hasMany(Actualizacion_etapa::class, 'id_etapa');
    }

    public function getResponsable()
    {
        return $this->belongsTo(Responsabilidad::class, 'id_responsabilidad');
    }

    public function getOrden()
    {
        return $this->hasMany(Orden::class, 'id_etapa');
    }

    public function getFechaFinalizacion()
    {
        if($this->getOrdenesFinalizadas() == $this->getTotalOrdenes()){
            $fechaExt = null;
            $ordenes = Orden::where('id_etapa', $this->id_etapa)->get();
            
            foreach ($ordenes as $orden) {
                return $orden->getPartes->sortByDesc('id_parte')->first()->fecha;
                if ($orden->getFinalizado() == 1) {
                    //$fechaExt = $orden->getFechaFinalizado();
                    $fechaExt = $orden->getPartes->sortByDesc('id_parte')->first()->fecha;
                }
            }

            return $fechaExt;
        }else{
            return null;
        }
    }

    public function getFechaLimite(){
        return $this->getActualizaciones->sortByDesc('id_actualizacion_etapa')->first()->getActualizacion->fecha_limite;
    }

    public function getProgreso(){
        $ordenes = Orden::where('id_etapa', $this->id_etapa)->get();
        $progreso = 0;
        
        try {
            $total = 100 / count($ordenes);
            foreach ($ordenes as $orden) {
                if ($orden->getFinalizado() == 1) {
                     $progreso += $total;
                } ;
             }
        } catch (\Throwable $th) {
            $total = 0;
        }

        return $progreso;     
    }

    public function getTotalOrdenes()
    {
        return count(Orden::where('id_etapa', $this->id_etapa)->get());
    }

    public function getOrdenesFinalizadas()
    {
        $ordenes = Orden::where('id_etapa', $this->id_etapa)->get();
        $totalOrdenesFinalizadas = 0;
        foreach ($ordenes as $orden) {

           if ($orden->getFinalizado() == 1) {
                $totalOrdenesFinalizadas +=1;
           }

        }
        return $totalOrdenesFinalizadas;
    }

    public function getOrdenesRealizadasPorcentaje()
    {
        if($this->getTotalOrdenes() > 0){
            return ceil(($this->getOrdenesFinalizadas()*100)/$this->getTotalOrdenes());
        }else{
            return '-';
        }
        
    }

    public function getCalculoHorasReales()
    {
        $ordenes = Orden::where('id_etapa', $this->id_etapa)->get();
        if(!is_null($ordenes)){
            $horas_reales = 0;
            $minutos_reales = 0;
            
            foreach($ordenes as $orden){
                $horas_reales += strstr($orden->getCalculoHorasReales(), ':', true);
                
                if (preg_match_all('/\:(.*?)\:/', $orden->getCalculoHorasReales(), $matches)) {
                    $minutos_reales += $matches[1][0];
                }

                if($minutos_reales >= 60){
                    $minutos_reales -= 60;
                    $horas_reales += 1;
                }
            }
            
            if(strlen($horas_reales) < 2){
                $horas_reales = '0'. $horas_reales;
            }
            if(strlen($minutos_reales) < 2){
                $minutos_reales = '0'. $minutos_reales;
            }
            $duracion_real = $horas_reales . ':' . $minutos_reales;
            return $duracion_real;
        }else{
            return '00:00';
        }
    }

    public function getCostoReal()
    {
        $ordenes = Orden::where('id_etapa', $this->id_etapa)->get();
        $costo_real = 0;
        foreach ($ordenes as $orden) {
            $costo_real = $costo_real + $orden->getCostoReal();
        }
        return round($costo_real, 2);
    }

    public function getCostoEstimado()
    {
        $ordenes = Orden::where('id_etapa', $this->id_etapa)->get();
        $costo_estimado = 0;
        foreach ($ordenes as $orden) {
            $costo_estimado = $costo_estimado + $orden->getCostoEstimado();
        }
        return round($costo_estimado, 2);
    }

    public function getCostoRealGuardado()
    {
        $ordenes = Orden::where('id_etapa', $this->id_etapa)->get();
        $costo_real = 0;
        foreach ($ordenes as $orden) {
            $costo_real = $costo_real + $orden->getCostoRealGuardado();
        }
        return round($costo_real, 2);
    }

    public function getCostoEstimadoGuardado()
    {
        $ordenes = Orden::where('id_etapa', $this->id_etapa)->get();
        $costo_estimado = 0;
        foreach ($ordenes as $orden) {
            $costo_estimado = $costo_estimado + $orden->costo_estimado;
        }
        return round($costo_estimado, 2);
    }
}