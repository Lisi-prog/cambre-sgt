<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Zona extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'zona';

    protected $primaryKey = 'id_zona';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_zona'
    ];
}