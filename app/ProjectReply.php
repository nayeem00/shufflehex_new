<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectReply extends Model
{
    protected $fillable = [
        'reply', 'user_id', 'project_id', 'comment_id', 'username',
    ];
    protected $dates=['deleted_at'];

    public function project_comments()
    {
        return $this->belongsTo('App\ProjectComment');
    }
    public function projects()
    {
        return $this->belongsTo('App\Project');
    }
}
