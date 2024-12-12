<?php

namespace App\Models\Cambre;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Empleado extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'empleado';

    protected $primaryKey = 'id_empleado';

    public $incrementing = true;

    protected $fillable = [ 
        'nombre_empleado',
        'email_empleado',
        'telefono_empleado',
        'id_puesto_empleado',
        'id_sector',
        'costo_hora',
        'user_id',
        'esta_activo'
    ];

    public function getRequerimientoIngenieria()
    {
        return $this->hasMany(Requerimiento_de_ingenieria::class, 'id_empleado');
    }

    public function getProyectos()
    {
        return $this->hasMany(Tic_Estados_x_Tarea::class, 'idtarea' ,'idtarea');
    }

    public function getPuestoEmpleado()
    {
        return $this->belongsTo(Puesto_empleado::class, 'id_puesto_empleado');
    }

    public function getSector()
    {
        return $this->belongsTo(Sector::class, 'id_sector');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getEmpleadoResponsable()
    {
        return $this->hasMany(Responsabilidad::class, 'id_empleado');
    }

    public function scopeActivo($query)
    {
        return $query->where('esta_activo', 1);
    }
    
    public function getOrganigrama(){
        return $this->hasOne(Og_organigrama::class, 'id_empleado');
    }

    public function getEmpmaq(){
        return $this->hasMany(Emp_x_maq::class, 'id_empleado');
    }
}