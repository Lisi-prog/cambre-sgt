<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Responsabilidad_orden extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'responsabilidad_orden';

    protected $primaryKey = 'id_responsabilidad_orden';

    public $incrementing = true;

    protected $fillable = [ 
        'id_responsabilidad',
        'id_orden'
    ];

    public function getOrden()
    {
        return $this->belongsTo(Empleado::class, 'id_orden');
    }

    public function getResponsabilidad()
    {
        return $this->belongsTo(Responsabilidad::class, 'id_responsabilidad');
    }

}