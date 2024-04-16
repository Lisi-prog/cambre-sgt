<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Doc_documento extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'doc_documento';

    protected $primaryKey = 'id_documento';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_documento',
        'descripcion_documento',
        'ubicacion_documento'
    ];

}