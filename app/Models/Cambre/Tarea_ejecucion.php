<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tarea_ejecucion extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tarea_ejecucion';

    protected $primaryKey = 'id_ejecucion';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_ejecucion'
    ];
}