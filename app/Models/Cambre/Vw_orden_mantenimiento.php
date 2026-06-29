<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\HoraMinutoCast;

class Vw_orden_mantenimiento extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'vw_orden_mantenimiento';

    protected $primaryKey = 'id_orden';

    public $incrementing = false;

    protected $fillable = [ 
        'prioridad_servicio',
        'id_servicio',
        'codigo_servicio',
        'nombre_servicio',
        'esta_activo',
        'id_orden',
        'id_tipo_orden_mantenimiento',
        'nombre_tipo_orden_mantenimiento',
        'nombre_orden',
        'id_etapa',
        'descripcion_etapa',
        'fecha_limite',
        'fecha_finalizacion',
        'id_estado_mantenimiento',
        'nombre_estado',
        'id_empleado_asignado',
        'nombre_empleado_asignado',
        'id_activo',
        'codigo_activo',
        'id_tipo_activo',
        'nombre_tipo_activo'
    ];

    public function getProgreso(){
        return 0;
        $ope_tot = 0;
        $ope_tot_com = 0;

        if ($this->total_ope) {
            $ope_tot = $this->total_ope;
        }

        if ($this->total_ope_completo) {
            $ope_tot_com = $this->total_ope_completo;
        }

        if ($ope_tot == 0) {
            return 0;
        } else {
            return ($ope_tot_com * 100) / $ope_tot;
        }
        
    }
    // protected $casts = [
    //     'total_horas' => HoraMinutoCast::class
    // ];
    
    // public function scopeResponsable($query, $responsable)
    // {
    //     if ($responsable == '') {
    //         return $query;
    //     } else{
    //         return $query->where('id_empleado_responsable', $responsable);
    //     }
        
    // }

    public function getOrden()
    {
        return $this->belongsTo(Orden::class, 'id_orden');
    }

     public function getPartes()
    {
        return $this->hasMany(Parte::class, 'id_orden', 'id_orden');
    }

    public function getEstadoActual(){
        return $this->getPartes->sortByDesc('id_parte')->first()->getParteDe->getEstado->nombre_estado_mantenimiento;
    }

    public function getTipoOrden()
    {
        return 4;
    }

    public function scopeServicio($query, $servicios){
        if ($servicios == '') {
            return $query;
        } else{
            return $query->whereIn('id_servicio', $servicios);
        }
    }

    public function scopeMantenimiento($query, $operaciones){
        if ($operaciones == '') {
            return $query;
        } else{
            return $query->whereIn('nombre_tipo_orden_mantenimiento', $operaciones);
        }
    }

    public function scopeEstado($query, $estados){
        if ($estados == '') {
            return $query;
        } else{
            return $query->whereIn('nombre_estado', $estados);
        }
    }

    public function scopeAsignado($query, $asignados){
        if ($asignados == '') {
            return $query;
        } else{
            return $query->whereIn('nombre_empleado_asignado', $asignados);
        }
    }

    public function scopeActivo($query, $activo){
        if ($activo == '') {
            return $query;
        } else{
            if ($activo) {
                return $query->where('esta_activo', 1);
            } else {
                return $query;
            }
        }
    }
}