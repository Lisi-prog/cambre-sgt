<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vw_servicio extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'vw_servicio';

    protected $primaryKey = 'id_servicio';

    public $incrementing = false;

    protected $fillable = [ 
        'prioridad_servicio',
        'id_servicio',
        'codigo_servicio',
        'nombre_servicio',
        'id_activo',
        'id_subtipo_servicio',
        'nombre_subtipo_servicio',
        'id_tipo_servicio',
        'nombre_tipo_servicio',
        'fecha_inicio',
        'id_empleado',
        'lider',
        'id_actualizacion',
        'fecha_limite',
        'id_estado',
        'nombre_estado',
        'total_ord',
        'total_ord_completa',
        'progreso'
    ];

    /* public function scopeDescripcion($query,$descripcion)
    {
        if ($descripcion == '') {
            return $query;
        } else {
            return $query->where('descripcion','like','%'.$descripcion.'%'); 
        }          
    } */
    
    public function scopeServicio($query, $cod_serv)
    {
        if ($cod_serv == '') {
            return $query;
        } else {
            return $query->whereIn('id_servicio', $cod_serv); 
        } 
    }

    public function scopeTipo($query, $tipo)
    {
        if ($tipo == '') {
            return $query;
        } else {
            return $query->WhereIn('id_subtipo_servicio', $tipo); 
        } 
    }

    public function scopePrefijo($query, $opcion, $prefijos)
    {
        switch ($opcion) {
            case 1:
                return $query;
                break;
            
            case 2:
                return $query->Where(function ($query) use($prefijos) {
                    foreach ($prefijos as $prefijo){
                       $query->orwhere('codigo_servicio', 'like', '%'.$prefijo.'%');
                    }      
                })->orWhereNotNull('id_activo');
                break;
    
            case 3:
                return $query->where('id_subtipo_servicio', 5)->orWhere(function ($query) use($prefijos) {
                                                                            foreach ($prefijos as $prefijo){
                                                                                $query->orWhere('codigo_servicio', 'like', '%'.$prefijo.'%');
                                                                            }      
                                                                        });
                break;

            case 4:
                return $query->orWhere(function ($query) use($prefijos) {
                                            foreach ($prefijos as $prefijo){
                                                $query->orWhere('codigo_servicio', 'like', '%'.$prefijo.'%');
                                            }      
                                        });
                break;
        }
    }

    public function scopeLider($query, $lider)
    {
        if ($lider == '') {
            return $query;
        } else {
            return $query->WhereIn('id_empleado', $lider); 
        } 
    }

    public function scopeEstado($query, $estado)
    {
        if ($estado == '') {
            return $query->where('id_estado', '<', 9);
        } else{
            return $query->WhereIn('id_estado', $estado);
        }
        
    }


    public function getEtapas()
    {
        return $this->hasMany(Etapa::class, 'id_servicio');
    }

    public function getActivo()
    {
        return $this->belongsTo(Activo::class, 'id_activo');
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

        $progreso = (object) array(
            'barra' => 0,
            'porcentaje' => 0
        );

        try {
            foreach ($etapas as $etapa) {
                $totalOrdenes += $etapa->getTotalOrdenes();
                $totalOrdenesFinalizados += $etapa->getOrdenesFinalizadas();
            }
            $progreso->porcentaje = ceil(($totalOrdenesFinalizados*100)/$totalOrdenes);
            $progreso->barra = $totalOrdenesFinalizados.'/'.$totalOrdenes;
        } catch (\Throwable $th) {
            $progreso->porcentaje = 0;
        }
        return $progreso;
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

    public function getSolicitud(){
        return $this->hasOne(Sol_solicitud::class, 'id_servicio');
    }

    public function getServiciosDeEsteActivo(){
        return Servicio::where('id_activo', $this->id_activo)->where('id_servicio', '<>', $this->id_servicio)->pluck('id_servicio');
    }
}