<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = [
        'review_comment','review_star', 'user_id', 'product_id', 'username',
    ];
    protected $dates=['deleted_at'];

    public function products()
    {
        return $this->belongsTo('App\Product');
    }
}
