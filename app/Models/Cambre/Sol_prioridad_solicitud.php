<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sol_prioridad_solicitud extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'sol_prioridad_solicitud';

    protected $primaryKey = 'id_prioridad_solicitud';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_prioridad_solicitud'
    ];

    public function getSolicitud()
    {
        return $this->hasMany(Sol_solicitud::class, 'id_prioridad_solicitud');
    }
}