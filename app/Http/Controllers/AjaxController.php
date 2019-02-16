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
            $fieldName = "is_".$request->topicsfilter;
            $posts = $posts->where($fieldName,"=",1);
        }

//        if($request->otherfilter != "none"){
//            if($request->otherfilter == 'upvote'){
//                $posts = $posts->orderByDesc(DB::raw('SUM(votes.vote)'));
//            }
//        }
        $posts = $posts
            ->offset(0)
            ->limit(10)
            ->get();

        if(sizeof($posts) != 0){
            return response()->json(['sucess'=>'true' , 'posts' => $posts]);
        }else{
            return response()->json(['sucess'=>'false']);
        }
    }

    public function popularTopics(){
        $categories = Category::join("post_views", "post_views.category_id", "=", "categories.id")
            ->where("post_views.created_at", ">=", date("Y-m-d H:i:s", strtotime('-24 hours', time())))
            ->groupBy("categories.id")
            ->orderByDesc(DB::raw('COUNT(post_views.view)'))
            ->limit(5)
            ->get();
        return $categories;
    }
}
