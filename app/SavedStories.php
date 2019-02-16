<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedStories extends Model
{
    protected $fillable = [
        'post_id', 'user_id','folder_id',
    ];
    protected $dates=['deleted_at'];

    public function posts()
    {
        return $this->belongsTo('App\Post');
    }
}
