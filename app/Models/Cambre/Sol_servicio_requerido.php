<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sol_servicio_requerido extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'sol_servicio_requerido';

    protected $primaryKey = 'id_servicio_requerido';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_servicio_requerido'
    ];
}