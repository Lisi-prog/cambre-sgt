<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sintoma extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'sintoma';

    protected $primaryKey = 'id_sintoma';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_sintoma', 'id_tipo_sintoma'
    ];

    public function getTipoSintoma()
    {
        return $this->hasOne(Tipo_sintoma::class, 'id_tipo_sintoma', 'id_tipo_sintoma');
    }
}