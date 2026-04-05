<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sol_servicio_de_mantenimiento extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'sol_servicio_de_mantenimiento';

    protected $primaryKey = 'id_servicio_de_mantenimiento';

    public $incrementing = true;

    protected $fillable = [ 
        'id_solicitud',
        'id_servicio_requerido',
        'id_activo',
        'id_sector'
    ];

    public function getSolicitud()
    {
        return $this->belongsTo(Sol_solicitud::class, 'id_solicitud');
    }

    public function getSector()
    {
        return $this->belongsTo(Sector::class, 'id_sector');
    }

    public function getActivo()
    {
        return $this->belongsTo(Activo::class, 'id_activo');
    }

    public function getSintomas()
    {
        return $this->hasMany(Sol_serv_man_x_sintoma::class, 'id_servicio_de_mantenimiento');
    }

    public function getSintomasAlt(){
        $idsSintomas = Sol_serv_man_x_sintoma::where('id_servicio_de_mantenimiento', $this->id_servicio_de_mantenimiento)->pluck('id_sintoma');

        $tipos = Tipo_sintoma::whereHas('getSintomas', function ($q) use ($idsSintomas) {
            $q->whereIn('id_sintoma', $idsSintomas);
        })
        ->with(['getSintomas' => function ($q) use ($idsSintomas) {
            $q->whereIn('id_sintoma', $idsSintomas);
        }])
        ->get();

        return $tipos->mapWithKeys(function ($tipo) {
            return [
                $tipo->id_tipo_sintoma => [
                    'tipo' => $tipo->nombre_tipo_sintoma,
                    'sintomas' => $tipo->getSintomas->map(fn($s) => [
                        'id' => $s->id_sintoma,
                        'nombre' => ucfirst($s->nombre_sintoma)
                    ])->values()
                ]
            ];
        });
    }
}