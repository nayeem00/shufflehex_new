<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'vote', 'post_id', 'user_id',
    ];
    protected $dates=['deleted_at'];

    public function posts()
    {
        return $this->belongsTo('App\Post');
    }
}
