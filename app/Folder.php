<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{


    public function folder_stories()
    {
        return $this->hasMany('App\FolderStory');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    public function projects()
    {
        return $this->hasMany('App\Project');
    }
}
