<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Maquinaria extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'maquinaria';

    protected $primaryKey = 'id_maquinaria';

    public $incrementing = true;

    protected $fillable = [ 
        'codigo_maquinaria',
        'alias_maquinaria',
        'descripcion_maquinaria',
        'id_sector'
    ];

    public function getSector()
    {
        return $this->belongsTo(Sector::class, 'id_sector');
    }

    public function getOpemaq(){
        return $this->hasMany(Ope_x_maq::class, 'id_maquinaria');
    }
    
}