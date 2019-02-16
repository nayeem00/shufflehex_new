<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedProduct extends Model
{
    protected $fillable = [
        'product_id', 'user_id','folder_id',
    ];
    protected $dates=['deleted_at'];

    public function products()
    {
        return $this->belongsTo('App\Product');
    }
}
