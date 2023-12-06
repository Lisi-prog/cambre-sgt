<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Puesto_empleado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'puesto_empleado';

    protected $primaryKey = 'id_puesto_empleado';

    public $incrementing = true;

    protected $fillable = [ 
        'titulo_puesto_empleado',
        'costo_hora'
    ];

    public function getEmpleados()
    {
        return $this->hasMany(Empleado::class, 'id_puesto_empleado');
    }
}