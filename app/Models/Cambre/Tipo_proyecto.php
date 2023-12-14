<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tipo_proyecto extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'tipo_proyecto';

    protected $primaryKey = 'id_tipo_proyecto';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_tipo_proyecto',
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}