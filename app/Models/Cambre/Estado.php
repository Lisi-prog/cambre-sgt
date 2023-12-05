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

    public $incrementing = false;

    protected $fillable = [ 
        'nombre_estado',
    ];

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }
}