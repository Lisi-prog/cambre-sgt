<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Parte_mantenimiento extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'parte_mantenimiento';

    protected $primaryKey = 'id_parte_mantenimiento';

    public $incrementing = true;

    protected $fillable = [ 
        'engase',
        'prueba_de_agua',
        'prueba_electrica',
        'id_parte',
        'id_estado'
    ];

    public function getEstado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function getParte()
    {
        return $this->belongsTo(Parte::class, 'id_parte');
    }

    public function getFinalizado()
    {
        if ($this->id_estado_mecanizado == 2) {
            return 1;
        }
        return 0;
    }
}