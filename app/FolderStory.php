<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FolderStory extends Model
{


    public function folders()
    {
        return $this->belongsTo('App\Folder');
    }
}
