<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sol_servicio_de_mantenimiento extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'sol_servicio_de_mantenimiento';

    protected $primaryKey = 'id_servicio_de_mantenimiento';

    public $incrementing = true;

    protected $fillable = [ 
        'id_solicitud',
        'id_servicio_requerido',
        'id_activo'
    ];

    public function getSolicitud()
    {
        return $this->belongsTo(Sol_solicitud::class, 'id_solicitud');
    }
}