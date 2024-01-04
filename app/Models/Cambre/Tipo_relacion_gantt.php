<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tipo_relacion_gantt extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tipo_relacion_gantt';

    protected $primaryKey = 'id_tipo_relacion_gantt';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_relacion_gantt'
    ];

    public function getOrdenesGantt()
    {
        return $this->hasMany(Orden_gantt::class, 'id_tipo_relacion_gantt');
    }
}