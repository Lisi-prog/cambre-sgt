<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tipo_sintoma extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tipo_sintoma';

    protected $primaryKey = 'id_tipo_sintoma';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_tipo_sintoma',
    ];

    public function getSintomas()
    {
        return $this->hasMany(Sintoma::class, 'id_tipo_sintoma');
    }
}