<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Prefijo_proyecto extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'prefijo_proyecto';

    protected $primaryKey = 'id_prefijo_proyecto';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_prefijo_proyecto',
        'descripcion_prefijo_proyecto'
    ];
}