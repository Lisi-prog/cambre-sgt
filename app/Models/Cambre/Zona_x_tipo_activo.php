<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Zona_x_tipo_activo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'zona_x_tipo_activo';

    protected $primaryKey = 'id_zona_x_tipo_activo';

    public $incrementing = true;

    protected $fillable = [ 
        'id_zona_x_tipo_activo',
        'id_zona',
        'id_tipo_activo'
    ];
}