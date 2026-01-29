<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sol_serv_man_x_sintoma extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'sol_serv_man_x_sintoma';

    protected $primaryKey = 'id_serv_man_x_sintoma';

    public $incrementing = true;

    protected $fillable = [ 
        'id_sintoma',
        'id_servicio_de_mantenimiento'
    ];

    public function getSintoma()
    {
        return $this->belongsTo(Sintoma::class, 'id_sintoma');
    }

    public function getSolicitudMant()
    {
        return $this->belongsTo(Sol_servicio_de_mantenimiento::class, 'id_servicio_de_mantenimiento');
    }
}