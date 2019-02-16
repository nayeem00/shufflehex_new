<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReply extends Model
{
    protected $fillable = [
        'reply', 'user_id', 'product_id', 'comment_id', 'username',
    ];
    protected $dates=['deleted_at'];

    public function product_comments()
    {
        return $this->belongsTo('App\ProductComment');
    }
    public function products()
    {
        return $this->belongsTo('App\Product');
    }
}
