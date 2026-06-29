<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Serv_mant_x_tarea_mant extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'serv_mant_x_tarea_mant';

    protected $primaryKey = 'id_serv_mant_x_tar_pre';

    public $incrementing = true;

    protected $fillable = [ 
        'id_serv_mant_x_tar_pre',
	    'id_servicio',
	    'id_tarea_prev_x_activo',
	    'id_tarea_prev_x_tipo_activo',
	    'fecha_carga',
	    'fecha_hecho',
    ];

    public function getServicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }

}