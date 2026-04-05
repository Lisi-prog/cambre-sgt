<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Parte_diag_x_causa extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'parte_diag_x_causa';

    protected $primaryKey = 'id_parte_diag_x_causa';

    public $incrementing = true;

    protected $fillable = [ 
        'id_parte_diagnostico', 'id_ishikawa_causa'
    ];

    public function getParteDiagnostico()
    {
        return $this->belongsTo(Parte_diagnostico::class, 'id_parte_diagnostico', 'id_parte_diagnostico');
    }

    public function getIshikawaCausa()
    {
        return $this->belongsTo(Ishikawa_causa::class, 'id_ishikawa_causa', 'id_ishikawa_causa');
    }
}

