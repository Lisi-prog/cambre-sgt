<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Og_organigrama extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'og_organigrama';

    protected $primaryKey = 'id_organigrama';

    public $incrementing = true;

    protected $fillable = [ 
        'id_empleado', 
        'id_supervisor_directo'
    ];

    public function getEmpleado()
    {
        return $this->belongsTo(Not_notificacion_cuerpo::class, 'id_not_cuerpo');
    }

    public function getSupervisorDirecto(){
        return $this->belongsTo(Empleado::class, 'id_supervisor_directo' ,'id_empleado');
    }
    
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado')->where('esta_activo', 1);
    }

    /**
     * Relación con el modelo Empleado para obtener el supervisor directo
     */
    public function supervisor()
    {
        return $this->belongsTo(Empleado::class, 'id_supervisor_directo');
    }
}