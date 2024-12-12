<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Emp_x_maq extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'emp_x_maq';

    protected $primaryKey = 'id_emp_x_maq';

    public $incrementing = true;

    protected $fillable = [ 
        'id_maquinaria',
        'id_empleado'
    ];

    public function getMaquinaria()
    {
        return $this->belongsTo(Maquinaria::class, 'id_maquinaria');
    }
}