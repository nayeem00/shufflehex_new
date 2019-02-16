<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    protected $fillable = [
        'comment', 'user_id', 'product_id', 'username',
    ];
    protected $dates=['deleted_at'];

    public function products()
    {
        return $this->belongsTo('App\Product');
    }
}
