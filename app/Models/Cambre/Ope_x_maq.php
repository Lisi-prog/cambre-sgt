<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Ope_x_maq extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'ope_x_maq';

    protected $primaryKey = 'id_ope_x_maq';

    public $incrementing = true;

    protected $fillable = [ 
        'id_maquinaria',
        'id_operacion'
    ];

    public function getMaquinaria()
    {
        return $this->belongsTo(Maquinaria::class, 'id_maquinaria');
    }

    public function getOperacion()
    {
        return $this->belongsTo(Operacion::class, 'id_operacion');
    }
}