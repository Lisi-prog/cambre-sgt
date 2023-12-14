<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Estado_solicitud extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'estado_solicitud';

    protected $primaryKey = 'id_estado_solicitud';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_estado_solicitud'
    ];

    public function getSolicitud()
    {
        return $this->hasMany(Solicitud::class, 'id_estado_solicitud');
    }
}