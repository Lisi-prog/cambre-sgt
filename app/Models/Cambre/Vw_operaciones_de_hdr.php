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
        'responsable',
        'codigo_maquinaria',
        'id_ope_de_hdr',
        'id_estado',
        'nombre_estado_hdr',
        'total_horas',
        'ultimo_res',
        'medidas'
    ];

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