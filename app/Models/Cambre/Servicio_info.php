<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Servicio_info extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'servicio_info';

    protected $primaryKey = 'id_servicio';

    public $incrementing = true;

    protected $fillable = [ 
        'id_servicio',
        'tot_ord',
        'tot_ord_completa',
        'progreso'
    ];

    public function getServicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }

}