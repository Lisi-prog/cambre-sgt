<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Ishikawa_causa extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'ishikawa_causa';

    protected $primaryKey = 'id_ishikawa_causa';

    public $incrementing = true;

    protected $fillable = [ 
        'id_ishikawa_categoria', 'nombre_causa', 'explicacion'
    ];

    public function getCategoria()
    {
        return $this->belongsTo(Ishikawa_categoria::class, 'id_ishikawa_categoria', 'id_ishikawa_categoria');
    }
}

