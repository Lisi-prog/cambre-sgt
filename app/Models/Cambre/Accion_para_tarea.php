<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Accion_para_tarea extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'accion_para_tarea';

    protected $primaryKey = 'id_accion_tarea';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_accion',
    ];
}