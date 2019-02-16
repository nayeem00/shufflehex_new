<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function index(){
        die("aa");
    }
    public function get_more_post(Request $request){
        $offset = $request->offset;
        $limit = 10;
        $newOffset = $offset + $limit;
//        echo $newOffset;
//        die($newOffset);
        $posts = Post::where('is_publish', 1)
            ->with('votes')
            ->with('comments')
            ->with('saved_stories')
            ->orderBy('views', 'DESC')
            ->offset($offset)
            ->limit($limit)
            ->get();

        if(sizeof($posts) != 0){
            return response()->json(['sucess'=>'true' , 'newOffset' => $newOffset, 'posts' => $posts]);
        }else{
            return response()->json(['sucess'=>'false']);
        }
    }

    public function get_filterd_post(Request $request){
        if($request->timefilter != "none"){
            $filterDate = null;
            switch ($request->timefilter){
                case "day" : $filterDate = date("Y-m-d");break;
                case "week" :  $filterDate = date("Y-m-d",strtotime('last Sunday'));break;
                case "month" :  $filterDate = date("Y-m-01");break;
                case "year" :  $filterDate = date("Y-01-01");break;
            }
        }
        $posts = Post::where('is_publish', 1)
            ->with('votes')
            ->with('comments')
            ->with('saved_stories');

        if($request->timefilter != "none"){
            $posts = $posts->where('created_at',">=",$filterDate);
        }

        if($request->topicsfilter != "none"){

        }

        if($request->otherfilter != "none"){

        }

        $posts = $posts
            ->orderBy('views', 'DESC')
            ->offset(0)
            ->limit(10)
            ->get();

        if(sizeof($posts) != 0){
            return response()->json(['sucess'=>'true' , 'posts' => $posts]);
        }else{
            return response()->json(['sucess'=>'false']);
        }
    }
}
