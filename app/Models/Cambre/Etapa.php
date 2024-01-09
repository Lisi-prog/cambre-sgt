<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Etapa extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'etapa';

    protected $primaryKey = 'id_etapa';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_etapa',
        'descripcion_etapa',
        'fecha_inicio',
        'id_servicio',
        'id_responsabilidad'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }

    public function getServicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }

    public function getActualizaciones()
    {
        return $this->hasMany(Actualizacion_etapa::class, 'id_etapa');
    }

    public function getResponsable()
    {
        return $this->belongsTo(Responsabilidad::class, 'id_responsabilidad');
    }

    public function getOrden()
    {
        return $this->hasMany(Orden::class, 'id_etapa');
    }

    public function getProgreso(){
        $ordenes = Orden::where('id_etapa', $this->id_etapa)->get();
        $progreso = 0;
        
        try {
            $total = 100 / count($ordenes);
            foreach ($ordenes as $orden) {
                if ($orden->getFinalizado() == 1) {
                     $progreso += $total;
                } ;
             }
        } catch (\Throwable $th) {
            $total = 0;
        }
        return $progreso;     
    }
}