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
        'codigo_servicio',
        'nombre_servicio',
        'descripcion_etapa',
        'nombre_orden',
        'id_hoja_de_ruta',
        'nombre_operacion',
        'codigo_maquinaria',
        'activo',
        'fecha',
        'numero',
        'id_estado_hdr',
        'nombre_estado_hdr',
        'ultimo_res',
        'total_horas',
        'medidas'
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

}