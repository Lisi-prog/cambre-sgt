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
        'id_sintoma',
        'id_tipo_activo'
    ];

    public function getSintoma()
    {
        return $this->belongsTo(Sintoma::class, 'id_sintoma');
    }

    public function getTipo()
    {
        return $this->belongsTo(Tipo_activa::class, 'id_tipo_activo');
    }
}