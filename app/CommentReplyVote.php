<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentReplyVote extends Model
{
    protected $fillable = [
        'vote', 'post_id', 'comment_id', 'reply_id', 'user_id',
    ];
    protected $dates=['deleted_at'];

    public function posts()
    {
        return $this->belongsTo('App\Post');
    }
}
