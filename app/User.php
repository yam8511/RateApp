<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'state'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rate()
    {
        return $this->hasOne('App\Rate', 'id');
    }

    public function belows()
    {
        return $this->hasMany('App\Relation', 'up');
    }

    public function up()
    {
        return $this->hasOne('App\Relation', 'id');
    }

    public function tests()
    {
        return $this->hasMany('App\Test', 'uid');
    }
}
