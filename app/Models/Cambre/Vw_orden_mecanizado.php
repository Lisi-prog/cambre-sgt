<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\HoraMinutoCast;

class Vw_orden_mecanizado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'vw_orden_mecanizado';

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
        'id_estado_mecanizado',
        'nombre_estado',
        'total_horas',
        'ope_act',
        'nom_est_ope_act',
        'ope_ult',
        'manufactura',
        'id_orden_manufactura',
        'total_ope',
        'total_ope_completo',
        'total_horas_hdr'
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

    public function getHdrActivo(){
        return $hojasDeRuta = Hoja_de_ruta::where('id_orden_mecanizado', $this->id_orden_mecanizado)->whereHas('getOperacionesHdr', function ($query) {
            $query->where('activo', 1);
        })->first();
    }

    public function getProgreso(){
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

}