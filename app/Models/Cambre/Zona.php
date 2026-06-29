<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Zona extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'zona';

    protected $primaryKey = 'id_zona';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_zona'
    ];

    public function getIdTipos(){
        return $idSubTipos = Zona_x_tipo_activo::where('id_zona', $this->id_zona)->pluck('id_tipo_activo');
    }

    public function getTipos(){
        $idSubTipos = Zona_x_tipo_activo::where('id_zona', $this->id_zona)->pluck('id_tipo_activo');


        return $subtipos = Tipo_activo::whereIn('id_tipo_activo', $idSubTipos)->orderBy('nombre_tipo_activo')->get()->pluck('nombre_tipo_activo')->implode(' - ');
    }
}