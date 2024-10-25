<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Not_notificacion extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'not_notificacion';

    protected $primaryKey = 'id_notificacion';

    public $incrementing = true;

    protected $fillable = [ 
        'user_id', 
        'id_not_cuerpo',
        'tipo',
        'leido',
        'created_at'
    ];

    public function getCuerpo()
    {
        return $this->belongsTo(Not_notificacion_cuerpo::class, 'id_not_cuerpo');
    }
}