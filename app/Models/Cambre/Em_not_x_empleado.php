<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Em_not_x_empleado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'em_not_x_empleado';

    protected $primaryKey = 'id_not_x_empleado';

    public $incrementing = true;

    protected $fillable = [ 
        'id_em_notificacion',
        'id_empleado'
    ];

    public function getEmpleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }
}