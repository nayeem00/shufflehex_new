<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    public function poll_items()
    {
        return $this->hasMany('App\PollItem');
    }
}
