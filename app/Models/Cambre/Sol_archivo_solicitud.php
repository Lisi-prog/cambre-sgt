<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sol_archivo_solicitud extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'sol_archivo_solicitud';

    protected $primaryKey = 'id_archivo_solicitud';

    public $incrementing = true;

    protected $fillable = [ 
        'id_solicitud',
        'nombre_archivo',
        'ruta'
    ];

    public function getSolicitud()
    {
        return $this->belongsTo(Sol_solicitud::class, 'id_solicitud');
    }
}