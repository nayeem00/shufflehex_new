<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name', 'product_images', 'short_desc', 'description', 'product_list_image', 'related_product_image', 'product_meta_image', 'yt_video_url', 'store_name', 'store_url', 'price','coupon','category','tags','user_id','username','views','product_votes','product_comments',
    ];
    protected $dates = ['deleted_at'];

    public function product_votes() {
        return $this->hasMany('App\ProductVote');
    }

    public function product_reviews() {
        return $this->hasMany('App\ProductReview');
    }

    public function saved_products() {
        return $this->hasMany('App\SavedProduct');
    }

    public function product_comment_votes() {
        return $this->hasMany('App\ProductCommentVote');
    }

    public function product_comment_reply_votes() {
        return $this->hasMany('App\ProductCommentReplyVote');
    }

    public function product_replies() {
        return $this->hasMany('App\ProductReply');
    }

    public function folders() {
        return $this->belongsTo('App\Folder');
    }
}
