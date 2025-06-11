<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tipo_activo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tipo_activo';

    protected $primaryKey = 'id_tipo_activo';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_tipo_activo'
    ];

}