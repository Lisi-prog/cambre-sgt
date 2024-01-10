<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Servicio extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'servicio';

    protected $primaryKey = 'id_servicio';

    public $incrementing = true;

    protected $fillable = [ 
        'codigo_servicio',
        'nombre_servicio',
        'fecha_inicio',
        'id_responsabilidad',
        'id_subtipo_servicio',
        'prioridad_servicio'
    ];

    public function getSubTipoServicio()
    {
        return $this->belongsTo(Subtipo_servicio::class, 'id_subtipo_servicio');
    }

    public function getResponsabilidad()
    {
        return $this->belongsTo(Responsabilidad::class, 'id_responsabilidad');
    }

    public function getPrioridad()
    {
        return $this->belongsTo(Prioridad::class, 'id_prioridad');
    }

    public function getActualizaciones()
    {
        return $this->hasMany(Actualizacion_servicio::class, 'id_servicio');
    }

    public function getUltimaActualizacion()
    {
        return $this->hasMany(Actualizacion_servicio::class, 'id_servicio')->first();
    }

    public function getEtapas()
    {
        return $this->hasMany(Etapa::class, 'id_servicio');
    }

    public function getEstado(){
        return $this->getActualizaciones->sortByDesc('id_actualizacion_servicio')->first()->getActualizacion->getEstado->nombre_estado;
    }

    public function getProgreso()
    {
        $etapas = $this->getEtapas;

        $total = 100 / count($etapas);
        
        $progreso = 0;

        foreach ($etapas as $etapa) {
            
            if ($etapa->getProgreso() == 100) {
                $progreso += $total;
            }else{
                $progreso += $etapa->getProgreso();
            }
        }

        return ceil($progreso);
    }

    public function getOrdenesRealizadas()
    {
        $etapas = $this->getEtapas;
        $totalOrdenes = 0;
        $totalOrdenesFinalizados = 0;

        foreach ($etapas as $etapa) {
            $totalOrdenes += $etapa->getTotalOrdenes();
            $totalOrdenesFinalizados += $etapa->getOrdenesFinalizadas();
        }
        return $totalOrdenesFinalizados.'/'.$totalOrdenes;
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
}