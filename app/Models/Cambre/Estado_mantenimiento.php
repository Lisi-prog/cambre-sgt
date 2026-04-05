<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Estado_mantenimiento extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'estado_mantenimiento';

    protected $primaryKey = 'id_estado_mantenimiento';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_estado_mantenimiento',
    ];
}