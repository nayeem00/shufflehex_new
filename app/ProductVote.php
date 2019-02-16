<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVote extends Model
{
    protected $fillable = [
        'vote', 'product_id', 'user_id',
    ];
    protected $dates=['deleted_at'];

    public function products()
    {
        return $this->belongsTo('App\Product');
    }
}
