<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico_categoria extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'diagnostico_categoria';

    protected $primaryKey = 'id_diagnostico_categoria';

    protected $fillable = [
        'nombre_diagnostico_categoria',
    ];

    public function getDiagnosticos()
    {
        return $this->hasMany(Diagnostico::class, 'id_diagnostico_categoria', 'id_diagnostico_categoria');
    }

    public function getTiposActivo()
    {
        return $this->belongsToMany(
            Tipo_activo::class,
            'diag_cat_x_tipo_activo',
            'id_diagnostico_categoria',
            'id_tipo_activo'
        )->using(Diag_cat_x_tipo_activo::class);
    }
}
