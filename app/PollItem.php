<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollItem extends Model
{
    protected $fillable = [
        'title','featured_image','description', 'post_id', 'user_id','username','item_votes',
    ];

    protected $dates=['deleted_at'];

    public function posts()
    {
        return $this->belongsTo('App\Post');
    }


}
