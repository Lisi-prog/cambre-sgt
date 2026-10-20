<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'diagnostico';

    protected $primaryKey = 'id_diagnostico';

    protected $fillable = [
        'nombre_diagnostico',
        'explicacion',
        'id_diagnostico_categoria',
        'en_uso',
    ];

    protected $attributes = [
        'en_uso' => 1,
    ];

    protected $casts = [
        'en_uso' => 'boolean',
    ];

    public function getCategoria()
    {
        return $this->belongsTo(Diagnostico_categoria::class, 'id_diagnostico_categoria', 'id_diagnostico_categoria');
    }
}
