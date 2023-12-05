<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Estado_mecanizado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'estado_mecanizado';

    protected $primaryKey = 'id_estado_mecanizado';

    public $incrementing = false;

    protected $fillable = [ 
        'nombre_estado_mecanizado',
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}