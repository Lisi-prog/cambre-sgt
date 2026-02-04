<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Activo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'activo';

    protected $primaryKey = 'id_activo';

    public $incrementing = true;

    protected $fillable = [ 
        'codigo_activo',
        'nombre_activo',
        'descripcion_activo',
        'esta_activo',
        'id_tipo_activo'
    ];

    public function getServicioDeMantenimiento()
    {
        return $this->hasMany(Servicio_de_mantenimiento::class, 'id_activo');
    }

    public function getServicioDeIngenieria()
    {
        return $this->hasMany(Servicio_de_ingenieria::class, 'id_activo');
    }

    public function getPropuestaDeMejora()
    {
        return $this->hasMany(Propuesta_de_mejora::class, 'id_activo');
    }

    public function getTipoActivo(){
        return $this->belongsTo(Tipo_activo::class, 'id_tipo_activo');
    }

    public function getServicioActivo(){
        return Servicio::where('id_activo', $this->id_activo)->where('id_subtipo_servicio', 7)->first();
    }

    public function getSintomas()
    {
        return $this->hasMany(Activo_x_sintoma::class,'id_activo','id_activo');
    }

    public function getSintomasSinUsar()
    {
        $sintomasUsadosIds = $this->getSintomas()->pluck('id_sintoma')->toArray();
        $sintomasUsadosIds = array_merge($sintomasUsadosIds, $this->getTipoActivo->getSintomas()->pluck('id_sintoma')->toArray());

        return Sintoma::whereNotIn('id_sintoma', $sintomasUsadosIds)->orderBy('nombre_sintoma', 'ASC')->get();
    }

    public function setSintomas($sintomasIds)
    {
        foreach ($sintomasIds as $id_sintoma) {
            $tipo_activo_x_sintoma = new Activo_x_sintoma();
            $tipo_activo_x_sintoma->id_activo = $this->id_activo;
            $tipo_activo_x_sintoma->id_sintoma = $id_sintoma;
            $tipo_activo_x_sintoma->save();
        }
    }
}