<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Diag_cat_x_tipo_activo extends Pivot
{
    public $timestamps = false;

    protected $table = 'diag_cat_x_tipo_activo';

    public $incrementing = false;

    protected $fillable = [
        'id_diagnostico_categoria',
        'id_tipo_activo',
    ];

    public function getCategoria()
    {
        return $this->belongsTo(Diagnostico_categoria::class, 'id_diagnostico_categoria', 'id_diagnostico_categoria');
    }

    public function getTipoActivo()
    {
        return $this->belongsTo(Tipo_activo::class, 'id_tipo_activo', 'id_tipo_activo');
    }
}
