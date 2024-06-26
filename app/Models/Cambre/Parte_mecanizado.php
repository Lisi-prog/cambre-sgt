<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Parte_mecanizado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'parte_mecanizado';

    protected $primaryKey = 'id_parte_mecanizado';

    public $incrementing = true;

    protected $fillable = [ 
        'id_estado_mecanizado',
        'id_parte'
    ];

    public function getEstadoMecanizado()
    {
        return $this->belongsTo(Estado_mecanizado::class, 'id_estado_mecanizado');
    }

    public function getNombreEstado(){
        return Estado_mecanizado::where('id_estado_mecanizado', $this->id_estado_mecanizado)->first()->nombre_estado_mecanizado;
    }

    public function getIdEstado(){
        return $this->id_estado_mecanizado;
    }

    public function getParte()
    {
        return $this->belongsTo(Parte::class, 'id_parte');
    }

    public function getFinalizado()
    {
        if ($this->id_estado_mecanizado == 6) {
            return 1;
        }
        return 0;
    }

    public function getParteMecxMaq(){
        return $this->hasMany(Parte_mecanizado_x_maquinaria::class, 'id_parte_mecanizado');
    }

    public function getTipoParte(){
        return 3;
    }
}