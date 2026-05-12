<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\HoraMinutoCast;

class Vw_operaciones_de_hdr extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'vw_operaciones_de_hdr';

    protected $primaryKey = 'id_ope_de_hdr';

    public $incrementing = false;

    protected $fillable = [ 
        'prioridad_servicio',
        'prioridad',
        'id_servicio',
        'codigo_servicio',
        'nombre_servicio',
        'descripcion_etapa',
        'nombre_orden',
        'id_hoja_de_ruta',
        'cantidad',
        'id_operacion',
        'nombre_operacion',
        'codigo_maquinaria',
        'activo',
        'fecha',
        'numero',
        'tecnico_asignado',
        'horas_estimada',
        'es_retrabajo',
        'id_estado_hdr',
        'nombre_estado_hdr',
        'ultimo_res',
        'total_horas',
        'total_horas_maquina',
        'medidas'
    ];

    protected $casts = [
        'horas_estimada' => HoraMinutoCast::class,
        'total_horas_maquina' => HoraMinutoCast::class,
        'total_horas' => HoraMinutoCast::class
    ];

    public function getMedidasAttribute()
    {
        if ($this->attributes['medidas']) {
            return 'SI';
        } else {
            return 'NO';
        }
    }
    
    public function getMedidaEstado(){
        $esta_validado = Parte_ope_hdr::where('medidas', 1)->where('id_ope_de_hdr', $this->id_ope_de_hdr)->first();

        if ($esta_validado) {
            return 1;
        } else {
            return 0;
        }

    }

    public function getHdr(){
        return $this->belongsTo(Hoja_de_ruta::class, 'id_hoja_de_ruta');
    }
   /* protected $casts = [
        'total_horas' => HoraMinutoCast::class
    ];

    public function scopeResponsable($query, $responsable)
    {
        if ($responsable == '') {
            return $query;
        } else{
            return $query->where('id_empleado_responsable', $responsable);
        }
        
    } */

    public function scopeServicio($query, $servicios){
        if ($servicios == '') {
            return $query;
        } else{
            return $query->whereIn('id_servicio', $servicios);
        }
    }

    public function scopeOperacion($query, $operaciones){
        if ($operaciones == '') {
            return $query;
        } else{
            return $query->whereIn('nombre_operacion', $operaciones);
        }
    }

    public function scopeMaquina($query, $maquinas){
        if ($maquinas == '') {
            return $query;
        } else{
            if (in_array('-', $maquinas)) {
                return $query->whereIn('codigo_maquinaria', $maquinas)->orWhereNull('codigo_maquinaria');
            } else {
                return $query->whereIn('codigo_maquinaria', $maquinas);
            }
        }
    }

    public function scopeEstado($query, $estados){
        if ($estados == '') {
            return $query;
        } else{
            return $query->whereIn('nombre_estado_hdr', $estados);
        }
    }

    public function scopeAsignado($query, $asignados){
        if ($asignados == '') {
            return $query;
        } else{
            return $query->whereIn('tecnico_asignado', $asignados);
        }
    }

    public function scopeActivo($query, $activo){
        if ($activo == '') {
            return $query;
        } else{
            if ($activo) {
                return $query->where('activo', 1);
            } else {
                return $query;
            }
        }
    }
    
}