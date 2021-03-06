<?php

namespace App;

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
        'name', 'username', 'email', 'password',
    ];
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    public function projects()
    {
        return $this->hasMany('App\Project');
    }
    public function social_infos()
    {
        return $this->hasOne('App\SocialInfo');
    }
    public function replies()
    {
        return $this->hasMany('App\Reply');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
