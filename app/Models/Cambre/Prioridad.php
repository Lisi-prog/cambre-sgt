<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Prioridad extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'prioridad';

    protected $primaryKey = 'id_prioridad';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_prioridad',
    ];

    public function getSolicitudes()
    {
        return $this->hasMany(Servicio::class, 'id_prioridad');
    }
}