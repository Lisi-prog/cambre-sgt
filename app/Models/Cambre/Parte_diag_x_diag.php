<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parte_diag_x_diag extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'parte_diag_x_diag';

    protected $primaryKey = 'id_parte_diag_x_diag';

    public $incrementing = true;

    protected $fillable = [
        'id_parte_diagnostico',
        'id_diagnostico',
    ];

    public function getParteDiagnostico()
    {
        return $this->belongsTo(Parte_diagnostico::class, 'id_parte_diagnostico', 'id_parte_diagnostico');
    }

    public function getDiagnostico()
    {
        return $this->belongsTo(Diagnostico::class, 'id_diagnostico', 'id_diagnostico');
    }
}
