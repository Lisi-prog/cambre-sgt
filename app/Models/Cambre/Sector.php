<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sector extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'sector';

    protected $primaryKey = 'id_sector';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_sector'
    ];

    public function getRequerimientoIngenieria()
    {
        return $this->hasMany(Requerimiento_de_ingenieria::class, 'id_sector');
    }

    public function getEmpleados()
    {
        return $this->hasMany(Empleado::class, 'id_sector');
    }
}