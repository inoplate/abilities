<?php

namespace Inoplate\Abilities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * Define roles relationship
     * 
     * @return Model
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Retrieve user abilities
     * 
     * @return collection
     */
    public function getAbilitiesAttribute()
    {
        $abilities = collect([]);

        foreach ($this->roles as $role) {
            $abilities = $abilities->merge($role->abilities);
        }

        return $abilities->unique();
    }
}
