<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Parte extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'parte';

    protected $primaryKey = 'id_parte';

    public $incrementing = true;

    protected $fillable = [ 
        'observaciones',
        'fecha',
        'fecha_limite',
        'fecha_carga',
        'horas',
        'costo',
        'id_orden',
        'id_responsabilidad'
    ];

    public function getEstado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function getResponsable()
    {
        return $this->belongsTo(Responsabilidad::class, 'id_responsabilidad');
    }

    public function getOrden()
    {
        return $this->belongsTo(Orden::class, 'id_orden');
    }

    public function getParteTrabajo()
    {
        return $this->hasOne(Parte_trabajo::class, 'id_parte');
    }

    public function getParteMecanizado()
    {
        return $this->hasOne(Parte_mecanizado::class, 'id_parte');
    }

    public function getParteManufactura()
    {   
        //return Parte_manufactura::where('id_parte', $this->id_parte)->first();
        return $this->hasOne(Parte_manufactura::class, 'id_parte');
    }

    public function getParteDe(){
        // return $this->hasOne(Parte_manufactura::class, 'id_parte');

        if (count(Parte_trabajo::where('id_parte', $this->id_parte)->get()) == 1) {
            return $this->hasOne(Parte_trabajo::class, 'id_parte');
        }

        if (count(Parte_mecanizado::where('id_parte', $this->id_parte)->get()) == 1) {
            return $this->hasOne(Parte_mecanizado::class, 'id_parte');
        }

        if (count(Parte_manufactura::where('id_parte', $this->id_parte)->get()) == 1) {
            return $this->hasOne(Parte_manufactura::class, 'id_parte');
        }

        if (count(Parte_mantenimiento::where('id_parte', $this->id_parte)->get()) == 1) {
            return $this->hasOne(Parte_mantenimiento::class, 'id_parte');
        }
    }
}