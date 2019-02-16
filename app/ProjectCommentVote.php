<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectCommentVote extends Model
{
    protected $fillable = [
        'vote', 'project_id', 'comment_id', 'user_id',
    ];
    protected $dates=['deleted_at'];

    public function projects()
    {
        return $this->belongsTo('App\Project');
    }
}
