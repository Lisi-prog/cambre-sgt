<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Not_notificacion_cuerpo extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'not_notificacion_cuerpo';

    protected $primaryKey = 'id_not_cuerpo';

    public $incrementing = true;

    protected $fillable = [ 
        'titulo',
        'mensaje',
        'url'
    ];
}