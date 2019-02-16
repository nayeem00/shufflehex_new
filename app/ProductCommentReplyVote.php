<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCommentReplyVote extends Model
{
    protected $fillable = [
        'vote', 'product_id', 'comment_id', 'reply_id', 'user_id',
    ];
    protected $dates=['deleted_at'];

    public function products()
    {
        return $this->belongsTo('App\Product');
    }
}
