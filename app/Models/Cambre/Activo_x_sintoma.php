<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Activo_x_sintoma extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'activo_x_sintoma';

    protected $primaryKey = 'id_activo_x_sintoma';

    public $incrementing = true;

    protected $fillable = [ 
        'id_activo', 'id_sintoma'
    ];

    public function getSintoma()
    {
        return $this->hasOne(Sintoma::class, 'id_sintoma', 'id_sintoma');
    }

    public function getActivo()
    {
        return $this->hasOne(Activo::class, 'id_activo', 'id_activo');
    }
}