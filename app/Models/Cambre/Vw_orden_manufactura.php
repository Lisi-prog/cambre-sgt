<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\HoraMinutoCast;

class Vw_orden_manufactura extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'vw_orden_manufactura';

    protected $primaryKey = 'id_orden';

    public $incrementing = false;

    protected $fillable = [ 
        'prioridad_servicio',
        'id_servicio',
        'codigo_servicio',
        'nombre_servicio',
        'nombre_orden',
        'descripcion_etapa',
        'fecha_limite',
        'fecha_finalizacion',
        'responsable',
        'id_empleado_responsable',
        'supervisor',
        'id_empleado_supervisor',
        'nombre_estado',
        'total_horas',
        'tot_mec',
        'tot_mec_completo',
        'tot_mec_porcentaje',
    ];

    protected $casts = [
        'total_horas' => HoraMinutoCast::class
    ];

    public function scopeResponsable($query, $responsable)
    {
        if ($responsable == '') {
            return $query;
        } else{
            return $query->where('id_empleado_responsable', $responsable);
        }
        
    }

    public function poseeOpeEnsam(){
        $idordman = Orden_manufactura::where('id_orden', $this->id_orden)->first()->id_orden_manufactura;
        if (Operaciones_de_hdr::where('id_orden_manufactura', $idordman)->first()) {
            return 1;
        } else {
            return 0;
        }
    }

    public function estaActivo(){
        $idordman = Orden_manufactura::where('id_orden', $this->id_orden)->first()->id_orden_manufactura;

        if (Operaciones_de_hdr::where('id_orden_manufactura', $idordman)->first()) {
            $ope = Operaciones_de_hdr::where('id_orden_manufactura', $idordman)->first();
            return $ope->activo;
        } else {
            return 0;
        }
    }

    public function getAsignado(){
        $idordman = Orden_manufactura::where('id_orden', $this->id_orden)->first()->id_orden_manufactura;

        if (Operaciones_de_hdr::where('id_orden_manufactura', $idordman)->first()) {
            $ope = Operaciones_de_hdr::where('id_orden_manufactura', $idordman)->first();
            return $ope->getNombreAsignadoOpeEnsa();
        } else {
            return '';
        }
    }
}