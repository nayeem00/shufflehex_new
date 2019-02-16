<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectCommentReplyVote extends Model
{
    protected $fillable = [
        'vote', 'project_id', 'comment_id', 'reply_id', 'user_id',
    ];
    protected $dates=['deleted_at'];

    public function projects()
    {
        return $this->belongsTo('App\Project');
    }
}
