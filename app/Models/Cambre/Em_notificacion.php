<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Em_notificacion extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'em_notificacion';

    protected $primaryKey = 'id_em_notificacion';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_em_notificacion',
        'descripcion_em_notificacion'
    ];

    public function getNotEmps()
    {
        return $this->hasMany(Em_not_x_empleado::class, 'id_em_notificacion');
    }
}