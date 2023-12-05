<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tipo_etapa extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tipo_etapa';

    protected $primaryKey = 'id_tipo_etapa';

    public $incrementing = false;

    protected $fillable = [ 
        'nombre_tipo_etapa'
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}