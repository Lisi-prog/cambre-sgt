<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Rol_x_sector extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'rol_x_sector';

    // protected $primaryKey = 'id_rol_empleado';

    public $incrementing = false;

    protected $fillable = [ 
        'id_sector',
        'id_rol'
    ];
}