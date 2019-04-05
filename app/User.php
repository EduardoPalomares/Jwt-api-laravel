<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable,SoftDeletes,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $guard_name = 'api';
     protected $table='users';
     protected $dates=['deleted_at'];

    protected $fillable = [
        'nombre',
        'email',
        'password',
    ];

    /**mUTADORES DE ACCESORES (SET AND GET )**/
    public function setNombreAttribute($valor)
    {
      $this->attributes['nombre']=strtolower($valor);
    }

    public function getNombreAttribute($valor)
    {
      return ucwords($valor);
    }

    /*public function setApellidosAttribute($valor)
    {
      $this->attributes['apellidos']=strtolower($valor);
    }*/

    public function getApellidosAttribute($valor)
    {
      return ucwords($valor);
    }

    public function setEmailAttribute($valor)
    {
      $this->attributes['email']=strtolower($valor);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
    *JWT TOKEN ACCES
    **/
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
