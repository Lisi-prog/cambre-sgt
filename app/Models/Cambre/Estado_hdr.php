<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Estado_hdr extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'estado_hdr';

    protected $primaryKey = 'id_estado_hdr';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_estado_hdr'
    ];

}