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
        'id_orden',
        'id_tipo_orden_mantenimiento',
        'nombre_orden',
        'id_etapa',
        'descripcion_etapa',
        'fecha_limite',
        'fecha_finalizacion',
        'id_estado_mantenimiento',
        'nombre_estado',
        'id_activo0',
        'nombre_activo'
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

}