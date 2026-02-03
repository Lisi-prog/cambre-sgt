<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Hdr_reg_retrabajo_ope extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'hdr_reg_retrabajo_ope';

    // protected $primaryKey = 'id_hdr_reg_trabajo';

    public $incrementing = false;

    protected $fillable = [ 
        'id_hdr_reg_retrabajo',
        'id_ope_de_hdr'
    ];

    public function getHdrRegRetrabajo()
    {
        return $this->belongsTo(Hdr_reg_retrabajo::class, 'id_hdr_reg_retrabajo');
    }

}