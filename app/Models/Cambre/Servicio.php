<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'prioridad_servicio',
        'id_activo',
        'id_servicio_padre'
    ];

    public function getSubTipoServicio()
    {
        return $this->belongsTo(Subtipo_servicio::class, 'id_subtipo_servicio');
    }

    public function cancelarOrdenesMantenimientoPendientes($idResponsabilidad, $fechaCarga)
    {
        $ordenes = Orden_mantenimiento::whereHas('getOrden.getEtapa', function ($query) {
            $query->where('id_servicio', $this->id_servicio);
        })->get();

        if ($ordenes->isEmpty()) {
            return;
        }

        $estadoCancelado = Estado_mantenimiento::where('nombre_estado_mantenimiento', 'Cancelado')->firstOrFail();

        foreach ($ordenes as $orden) {
            $ultimoParte = $orden->getPartes()->orderByDesc('id_parte')->first();
            $detalle = $ultimoParte ? $ultimoParte->getParteDe : null;

            if ($detalle) {
                $idEstado = $detalle instanceof Parte_diagnostico || $detalle instanceof Parte_mantenimiento
                    ? $detalle->id_estado
                    : $detalle->id_estado_mantenimiento;
                $completo = $detalle instanceof Parte_diagnostico
                    ? (bool) $detalle->completado
                    : ($detalle instanceof Parte_mantenimiento ? $idEstado == 9 : $idEstado == 4);

                if ($completo || $idEstado == ($detalle instanceof Parte_mantenimiento ? 10 : $estadoCancelado->id_estado_mantenimiento)) {
                    continue;
                }
            }

            $parte = Parte::create([
                'observaciones' => 'Orden cancelada por cancelación del servicio de mantenimiento.',
                'fecha' => $fechaCarga,
                'fecha_carga' => $fechaCarga,
                'fecha_limite' => $ultimoParte ? $ultimoParte->fecha_limite : null,
                'horas' => '00:00',
                'costo' => 0,
                'id_orden' => $orden->id_orden,
                'id_responsabilidad' => $idResponsabilidad,
            ]);

            if ($detalle instanceof Parte_mantenimiento) {
                Parte_mantenimiento::create(['id_parte' => $parte->id_parte, 'id_estado' => 10]);
            } elseif ($orden->id_tipo_orden_mantenimiento == 1) {
                Parte_diagnostico::create([
                    'id_parte' => $parte->id_parte,
                    'id_estado' => $estadoCancelado->id_estado_mantenimiento,
                    'en_maquina' => $detalle ? $detalle->en_maquina : 0,
                    'en_banco' => $detalle ? $detalle->en_banco : 0,
                    'completado' => 0,
                ]);
            } else {
                $modelo = $orden->id_tipo_orden_mantenimiento == 2 ? Parte_inspeccion::class : Parte_ajuste::class;
                $modelo::create([
                    'id_parte' => $parte->id_parte,
                    'id_estado_mantenimiento' => $estadoCancelado->id_estado_mantenimiento,
                ]);
            }

            $orden->update(['esta_activo' => 0]);
        }
    }

    public function getActivo()
    {
        return $this->belongsTo(Activo::class, 'id_activo');
    }

    public function servicioPadre()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio_padre');
    }

    public function serviciosHijos()
    {
        return $this->hasMany(Servicio::class, 'id_servicio_padre');
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
        return $this->hasMany(Actualizacion_servicio::class, 'id_servicio')->orderByDesc('id_actualizacion_servicio')->first();
    }

    public function ultimaActualizacion()
    {
        return $this->hasOne(Actualizacion_servicio::class, 'id_servicio')
            ->latestOfMany('id_actualizacion_servicio');
    }

    public function getEtapas()
    {
        return $this->hasMany(Etapa::class, 'id_servicio');
    }

    public function getEstado(){
        return $this->getActualizaciones->sortByDesc('id_actualizacion_servicio')->first()->getActualizacion->getEstado->nombre_estado;
    }

    public function getIdEstado(){
        return $this->getActualizaciones->sortByDesc('id_actualizacion_servicio')->first()->getActualizacion->getEstado->id_estado;
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

    public function getCostoReal()
    {
        $etapas = Etapa::where('id_servicio', $this->id_servicio)->get();
        $costo_real = 0;
        foreach ($etapas as $etapa) {
            $costo_real = $costo_real + $etapa->getCostoReal();
        }
        return round($costo_real, 2);
    }

    public function getCostoEstimado()
    {
        $etapas = Etapa::where('id_servicio', $this->id_servicio)->get();
        $costo_estimado = 0;
        foreach ($etapas as $etapa) {
            $costo_estimado = $costo_estimado + $etapa->getCostoEstimado();
        }
        return round($costo_estimado, 2);
    }

    public function getCostoRealGuardado()
    {
        $etapas = Etapa::where('id_servicio', $this->id_servicio)->get();
        $costo_real = 0;
        foreach ($etapas as $etapa) {
            $costo_real = $costo_real + $etapa->getCostoRealGuardado();
        }
        return round($costo_real, 2);
    }

    public function getCostoEstimadoGuardado()
    {
        $etapas = Etapa::where('id_servicio', $this->id_servicio)->get();
        $costo_estimado = 0;
        foreach ($etapas as $etapa) {
            $costo_estimado = $costo_estimado + $etapa->getCostoEstimadoGuardado();
        }
        return round($costo_estimado, 2);
    }

    public function getSolicitud(){
        return $this->hasOne(Sol_solicitud::class, 'id_servicio');
    }

    public function tieneOrdenMantAjusteCompleto(){

        $resultado = DB::select("SELECT EXISTS (
                        SELECT 1
                        FROM etapa e
                        INNER JOIN orden o ON o.id_etapa = e.id_etapa
                        INNER JOIN parte p ON p.id_orden = o.id_orden
                        INNER JOIN parte_ajuste pa ON pa.id_parte = p.id_parte
                        WHERE e.id_servicio = :idserv
                    ) AS tiene_ajuste", ["idserv" => $this->id_servicio]);

        return (int) $resultado[0]->tiene_ajuste;
    }
}
