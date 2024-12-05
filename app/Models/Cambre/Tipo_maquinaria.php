<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tipo_maquinaria extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tipo_maquinaria';

    protected $primaryKey = 'id_tipo_maquinaria';

    public $incrementing = true;

    protected $fillable = [ 
        'tipo_maquinaria'
    ];

}