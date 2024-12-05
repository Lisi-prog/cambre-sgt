<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Operacion extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'operacion';

    protected $primaryKey = 'id_operacion';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_operacion'
    ];

}