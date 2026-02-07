<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sol_serv_ing_x_sintoma extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'sol_serv_ing_x_sintoma';

    protected $primaryKey = 'id_sol_serv_ing_x_sintoma';

    public $incrementing = true;

    protected $fillable = [ 
        'id_servicio_de_ingenieria', 'id_sintoma'
    ];

    public function getSintoma()
    {
        return $this->hasOne(Sintoma::class, 'id_sintoma', 'id_sintoma');
    }

    public function getServicioDeIngenieria()
    {
        return $this->hasOne(Sol_servicio_de_ingenieria::class, 'id_servicio_de_ingenieria');
    }
}