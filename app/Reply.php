<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'reply', 'user_id', 'post_id', 'comment_id', 'username',
    ];
    protected $dates=['deleted_at'];

    public function comments()
    {
        return $this->belongsTo('App\Comment');
    }
    public function posts()
    {
        return $this->belongsTo('App\Post');
    }
}
