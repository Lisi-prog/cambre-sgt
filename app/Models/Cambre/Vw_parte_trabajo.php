<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\HoraMinutoCast;

class Vw_parte_trabajo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'vw_parte_trabajo';

    protected $primaryKey = 'id_parte';

    public $incrementing = false;

    protected $fillable = [ 
        'nombre_orden',
        'fecha',
        'fecha_limite',
        'estado',
        'horas',
        'observaciones',
        'id_servicio',
        'codigo_servicio',
        'nombre_servicio',
        'descripcion_etapa',
        'responsable',
        'id_responsable',
        'supervisor',
        'id_supervisor'
    ];

    protected $casts = [
        'horas' => HoraMinutoCast::class
    ];

    public function scopeResponsable($query, $responsable)
    {
        if ($responsable == '') {
            return $query;
        } else{
            return $query->whereIn('id_responsable', $responsable);
        }
        
    }

    public function scopeSupervisor($query, $supervisor)
    {
        if ($supervisor == '') {
            return $query;
        } else{
            return $query->whereIn('id_supervisor', $supervisor);
        }
        
    }

    public function scopeServicio($query, $cod_serv)
    {
        if ($cod_serv == '') {
            return $query;
        } else {
            return $query->whereIn('id_servicio', $cod_serv); 
        } 
    }

    public function scopeFecha($query, $from, $to)
    {
        if ($from != '') {
            return $query->where('fecha', '>=', $from);
        }

        if ($to != '') {
            return $query->where('fecha', '<=', $to);
        }
        
        if ($from == '' && $to == '') {
            return $query;
        } else {
            return $query->whereBetween('fecha', [$from, $to]); 
        } 
    }
}