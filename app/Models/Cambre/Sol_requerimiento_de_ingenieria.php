<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sol_requerimiento_de_ingenieria extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'sol_requerimiento_de_ingenieria';

    protected $primaryKey = 'id_requerimiento_de_ingenieria';

    public $incrementing = true;

    protected $fillable = [ 
        'id_solicitud',
        'id_sector'
    ];

    public function getSolicitud()
    {
        return $this->belongsTo(Sol_solicitud::class, 'id_solicitud');
    }

    public function getSector()
    {
        return $this->belongsTo(Sector::class, 'id_sector');
    }
}