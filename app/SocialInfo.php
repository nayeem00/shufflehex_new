<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialInfo extends Model
{
    protected $fillable = [
        'user_id', 'username', 'facebook', 'google_plus','linked_in',
    ];
    protected $dates=['deleted_at'];

    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
