<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Cambre\Empleado;
use App\Models\Cambre\Not_notificacion;
use App\Models\Cambre\Emp_x_maq;
use App\Models\Cambre\Ope_x_maq;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getEmpleado()
    {
        return $this->hasOne(Empleado::class, 'user_id' ,'id');
    }

    public function getNotificaciones()
    {
        return $this->hasMany(Not_notificacion::class, 'user_id' ,'id');
    }

    public function getOperacionesValidas(){
        try {
            $idsMaq = Emp_x_maq::where('id_empleado', $this->getEmpleado->id_empleado)->pluck('id_maquinaria');
            return Ope_x_maq::whereIn('id_maquinaria', $idsMaq)->pluck('id_operacion');
        } catch (\Throwable $th) {
            return [];
        }
    }
}
