<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tipo_activo_x_sintoma extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tipo_activo_x_sintoma';

    protected $primaryKey = 'id_tipo_activo_x_sintoma';

    public $incrementing = true;

    protected $fillable = [ 
        'id_tipo_activo', 'id_sintoma'
    ];

    public function getSintoma()
    {
        return $this->hasOne(Sintoma::class, 'id_sintoma', 'id_sintoma');
    }

    public function getTipoActivo()
    {
        return $this->hasOne(Tipo_activo::class, 'id_tipo_activo', 'id_tipo_activo');
    }
}