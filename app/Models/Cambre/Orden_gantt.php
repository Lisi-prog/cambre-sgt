<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Orden_gantt extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'orden_gantt';

    protected $primaryKey = 'id_orden_gantt';

    public $incrementing = true;

    protected $fillable = [ 
        'id_orden_anterior',
        'id_orden_siguiente',
        'id_tipo_relacion_gantt'
    ];

    public function getNombreRelacionGantt()
    {
        return $this->belongsTo(Tipo_relacion_gantt::class, 'id_tipo_relacion_gantt');
    }
}