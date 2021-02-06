<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use Notifiable;
    use HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre','apellido','username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends =['nombre_completo'];

    public function roles()
    {
        return $this->belongsToMany('Caffeinated\Shinobi\Models\Role');
    }

    public function getNombreCompletoAttribute(){
        return $this->attributes['nombre'].' '.$this->attributes['apellido'];
    }

    public function getRolAttribute(){
        return $this->roles()->get();
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('Activos', function (Builder $builder) {
            $builder->where('activo', 'si');
        });
    }

}
