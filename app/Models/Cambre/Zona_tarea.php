<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Zona_tarea extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'zona_tarea';

    protected $primaryKey = 'id_zona_tarea';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_zona_tarea'
    ];
}