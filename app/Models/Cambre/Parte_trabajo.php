<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Parte_trabajo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'parte_trabajo';

    protected $primaryKey = 'id_parte_trabajo';

    public $incrementing = true;

    protected $fillable = [
        'id_estado',
        'id_parte' 
    ];

    public function getEstado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function getNombreEstado(){
        return Estado::where('id_estado', $this->id_estado)->first()->nombre_estado;
    }

    public function getParte()
    {
        return $this->belongsTo(Parte::class, 'id_parte');
    }

    public function getFinalizado()
    {
        if ($this->id_estado == 2) {
            return 1;
        }
        return 0;
    }
}