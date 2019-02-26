<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use Illuminate\Support\Facades\URL;

class FeedController extends Controller
{
    public function feed()
    {
        $posts = Post::where('is_publish',1)->orderByDesc('created_at')->get();
        return view('pages/feed')->with(compact('posts'));
    }

}
