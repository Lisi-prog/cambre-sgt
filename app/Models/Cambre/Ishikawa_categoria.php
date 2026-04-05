<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Ishikawa_categoria extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'ishikawa_categoria';

    protected $primaryKey = 'id_ishikawa_categoria';

    public $incrementing = true;

    protected $fillable = [ 
        'codigo_categoria', 'nombre_categoria'
    ];
}

