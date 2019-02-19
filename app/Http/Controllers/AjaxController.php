<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\PostHelper;
use App\Http\SettingsHelper;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function index(){
        die("aa");
    }
    public function get_more_post(Request $request){
        $offset = $request->offset;
        $limit = SettingsHelper::getSetting('story_limit')->value;
        $newOffset = $offset + $limit;
        $posts = Post::where('is_publish', 1)
            ->with('votes')
            ->with('comments')
            ->with('saved_stories')
            ->orderBy('views', 'DESC')
            ->offset($offset)
            ->limit($limit)
            ->get();
        $posts = PostHelper::addAditionalData($posts);

        $postsData =  (string) view()->make("partials.post_item",['posts' =>$posts]);

        if(sizeof($posts) != 0){
            return json_encode(['sucess'=>'true' , 'newOffset' => $newOffset, 'postsData' =>  $postsData]);
        }else{
            return response()->json(['sucess'=>'false']);
        }
    }

    public function get_filterd_post(Request $request){

        $posts = Post::select('posts.*')
            ->where('is_publish', 1)
            ->with('votes')
            ->with('comments')
            ->with('post_views')
            ->with('saved_stories');

        $filterParams = $request;

        PostHelper::filterPostQuery($posts,$filterParams);


        $limit = SettingsHelper::getSetting('story_limit')->value;
        $offset = 0;
        $newOffset = $offset + $limit;
        $posts = $posts
            ->offset($offset)
            ->limit($limit)
            ->get();

        $posts = PostHelper::addAditionalData($posts);

//        if($request->otherfilter != "none"){
//            $c = collect($posts);
//            switch ($request->otherfilter){
//                case "upvote" :  $sorted = $c->sortBy('vote_number');;break;
//                case "downvote" :  $filterDate = date("Y-m-d",strtotime('last Sunday'));break;
//                case "page-view" :  $filterDate = date("Y-m-01");break;
//                case "most-comment" :  $filterDate = date("Y-01-01");break;
//            }
//            $posts = $sorted->all();
//        }



        $postsData =  (string) view()->make("partials.post_item",['posts' =>$posts]);

        if(sizeof($posts) != 0){
            return response()->json(['sucess'=>'true' , 'newOffset' => $newOffset,'postsData' => $postsData]);
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
