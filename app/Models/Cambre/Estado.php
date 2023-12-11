<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Estado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'estado';

    protected $primaryKey = 'id_estado';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_estado',
    ];

    public function getSolicitudes()
    {
        return $this->hasMany(Solicitud::class, 'id_estado');
    }
}