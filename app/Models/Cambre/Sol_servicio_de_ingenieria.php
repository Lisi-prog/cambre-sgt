<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sol_servicio_de_ingenieria extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'sol_servicio_de_ingenieria';

    protected $primaryKey = 'id_servicio_de_ingenieria';

    public $incrementing = true;

    protected $fillable = [ 
        'id_solicitud',
        'id_sector',
        'id_activo',
        'id_servicio_requerido'
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

    public function getSintomasAlt(){
        $idsSintomas = Sol_serv_ing_x_sintoma::where('id_servicio_de_ingenieria', $this->id_servicio_de_ingenieria)->pluck('id_sintoma');

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

    public function getNombreServicioMan(){
        $existeServicioMant = Servicio::where('id_subtipo_servicio', 6)->where('id_activo', $this->id_activo)->orderBy('id_servicio', 'desc')->first();

        if ($existeServicioMant) {
            $ultNombre = $existeServicioMant->codigo_servicio;

            // obtener los últimos 4 caracteres
            $numeroNom = substr($ultNombre, -4);

            // pasarlo a entero y sumar 1
            $nuevoNumero = (int)$numeroNom + 1;

            // volver a formatear a 4 dígitos
            $numServ = str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
        } else {
            $numServ = '0001';
        }

        $codActivo = Activo::find($this->id_activo)->codigo_activo;

        // $numServ = 0001;

        return $codigo_proyecto = $codActivo.'-MAN-'.$numServ;
    }
}