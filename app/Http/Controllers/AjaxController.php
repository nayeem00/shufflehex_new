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
    public function get_more_post(Request $request){

        $offset = $request->offset;
        $limit = SettingsHelper::getSetting('story_limit')->value;
        $newOffset = $offset + $limit;
        $posts = Post::select('posts.*')
            ->where('is_publish', 1)
            ->with('votes')
            ->with('comments')
            ->with('saved_stories');

        if($request->pageKey == "story-category"){
            $searchCategory = str_replace("+", $request->searchCategory," ");
            $posts = $posts->where('category', '=', $request->searchCategory);
        }

        //--------------filter here if exists ---------//
        if($request->filterParam){
            $filterParams = (object) $request->filterParam;
            PostHelper::filterPostQuery($posts,$filterParams);
        }



        $posts= $posts->offset($offset)
            ->limit($limit)
            ->get();
        $posts = PostHelper::addAditionalData($posts);

        $postsData =  (string) view()->make("partials.post_item",['posts' =>$posts,'pageKey' => $request->pageKey]);

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



        if($request->pageKey == "story-category"){
            $searchCategory = str_replace("+", $request->searchCategory," ");
            $posts = $posts->where('category', '=', $request->searchCategory);
        }



        //--------------filter here if exists ---------//
        if($request->filterParam){
            $filterParams = (object) $request->filterParam;
            PostHelper::filterPostQuery($posts,$filterParams);
        }


        $limit = SettingsHelper::getSetting('story_limit')->value;
        $offset = 0;
        $newOffset = $offset + $limit;
        $posts = $posts
            ->offset($offset)
            ->limit($limit)
            ->get();



        $posts = PostHelper::addAditionalData($posts);


        $postsData =  (string) view()->make("partials.post_item",['posts' =>$posts,'pageKey' => $request->pageKey]);

        if(sizeof($posts) != 0){
            return response()->json(['sucess'=>'true' , 'newOffset' => $newOffset,'postsData' => $postsData]);
        }else{
            return response()->json(['sucess'=>'false']);
        }
    }

}
