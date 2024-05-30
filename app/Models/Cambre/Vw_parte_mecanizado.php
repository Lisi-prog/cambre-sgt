<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\HoraMinutoCast;

class Vw_parte_mecanizado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'vw_parte_manufactura';

    protected $primaryKey = 'id_parte';

    public $incrementing = false;

    protected $fillable = [ 
        'nombre_orden',
        'fecha',
        'fecha_limite',
        'estado',
        'horas',
        'observaciones',
        'codigo_servicio',
        'descripcion_etapa',
        'responsable',
        'id_responsable',
        'supervisor',
        'id_supervisor',
        'horas_maquina',
        'id_maquinaria',
        'codigo_maquinaria'
    ];

    protected $casts = [
        'horas' => HoraMinutoCast::class
    ];

    public function scopeResponsable($query, $responsable)
    {
        if ($responsable == '') {
            return $query;
        } else{
            return $query->where('id_responsable', $responsable);
        }
        
    }

}