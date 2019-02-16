<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\UserNotifications;
use App\User;
use App\Product;
use App\ProductReview;
use Auth;

class ProductReviewController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth', ['only' => ['store']]);
    }
    public function store(Request $request)
    {
        $product = Product::find($request->product_id);
        $userOfPost = User::find($product->user_id);

        $user = User::find(Auth::user()->id);
        $review = new ProductReview();
        $review->review_comment = $request->review_comment;
        $review->review_stars = $request->review_star;
        $review->product_id = $request->product_id;
        $review->user_id = $user->id;
        $review->username = $user->username;
        $review->save();
        $userOfPost->notify(new UserNotifications($review));
        $productReview = ProductReview::where('product_id',$request->product_id)->avg('review_stars');
//        dd($productReview);
        $totalReviews = ProductReview::where('product_id',$request->product_id)->count('id');
        $product->product_review = $productReview;
        $product->total_reviews = $totalReviews;
        $product->update();

        return back();
    }
}
