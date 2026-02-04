<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Parte_diagnostico extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'parte_diagnostico';

    protected $primaryKey = 'id_parte_diagnostico';

    public $incrementing = true;

    protected $fillable = [ 
        'id_parte', 'id_estado', 'en_maquina', 'en_banco'
    ];

    public function getParte()
    {
        return $this->belongsTo(Parte::class, 'id_parte', 'id_parte');
    }
}

