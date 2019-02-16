<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollVote extends Model
{
    protected $fillable = [
        'vote', 'poll_item_id', 'user_id',
    ];
    protected $dates=['deleted_at'];


}
