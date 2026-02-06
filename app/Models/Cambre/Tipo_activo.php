<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tipo_activo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tipo_activo';

    protected $primaryKey = 'id_tipo_activo';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_tipo_activo'
    ];

    public function getSintomas()
    {
        return $this->hasMany(Tipo_activo_x_sintoma::class,'id_tipo_activo','id_tipo_activo');
    }

    public function getSintomasSinUsar()
    {
        $sintomasUsadosIds = $this->getSintomas()->pluck('id_sintoma')->toArray();

        return Sintoma::whereNotIn('id_sintoma', $sintomasUsadosIds)->orderBy('nombre_sintoma', 'ASC')->get();
    }

    public function setSintomas($sintomasIds)
    {
        foreach ($sintomasIds as $id_sintoma) {
            $tipo_activo_x_sintoma = new Tipo_activo_x_sintoma();
            $tipo_activo_x_sintoma->id_tipo_activo = $this->id_tipo_activo;
            $tipo_activo_x_sintoma->id_sintoma = $id_sintoma;
            $tipo_activo_x_sintoma->save();
        }
    }

    public function getTareasMantenimiento(){    
         return $this->hasMany(Tipo_activo_x_tarea_mant::class,'id_tipo_activo','id_tipo_activo');
    }

    public function getTareasMantenimientoSinUsar()
    {
        $tareasUsadasIds = $this->getTareasMantenimiento()->pluck('id_tarea_mantenimiento')->toArray();

        return Tarea_mantenimiento::whereNotIn('id_tarea_mantenimiento', $tareasUsadasIds)->orderBy('nombre_tarea', 'ASC')->get();
    }

    public function setTareasMantenimiento($tareasIds)
    {
        foreach ($tareasIds as $id_tarea_mant) {
            $tipo_activo_x_tarea_mant = new Tipo_activo_x_tarea_mant();
            $tipo_activo_x_tarea_mant->id_tipo_activo = $this->id_tipo_activo;
            $tipo_activo_x_tarea_mant->id_tarea_mantenimiento = $id_tarea_mant;
            $tipo_activo_x_tarea_mant->save();
        }
    }

}