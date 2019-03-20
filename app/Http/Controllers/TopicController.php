<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Post;

class TopicController extends Controller
{
    public function index()
    {
      $topics = Category::all();

      foreach ($topics as $topic){
        $countPost = Post::where('category',$topic->category)->count('id');
        $topic->countStory = $countPost;
      }
      return view('pages/allTopics',compact('topics'));
    }
}
