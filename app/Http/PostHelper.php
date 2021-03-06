<?php
/**
 * Created by PhpStorm.
 * User: anowe
 * Date: 2/19/2019
 * Time: 4:19 PM
 */

namespace App\Http;


use App\Settings;
use DateTime;
use Auth;
use Illuminate\Support\Facades\DB;

class PostHelper
{
    public static  function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }

        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
    public static function getFacebookCount($link)
    {
        $cSession = curl_init();
        $api_link = "https://graph.facebook.com/?id={$link}";
        curl_setopt($cSession, CURLOPT_URL, $api_link);
        curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cSession, CURLOPT_HEADER, false);
        $result = curl_exec($cSession);
        curl_close($cSession);

        $result = json_decode($result);
        return $result->share->share_count;
    }

    public static function getPinterestCount($link)
    {
        $cSession = curl_init();
        $api_link = "https://api.pinterest.com/v1/urls/count.json?callback=jsonp&url={$link}";
        curl_setopt($cSession, CURLOPT_URL, $api_link);
        curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cSession, CURLOPT_HEADER, false);
        $result = curl_exec($cSession);
        curl_close($cSession);
        $result = preg_replace("/[^(]*\((.*)\)/", "$1", $result);
        $result = json_decode($result);
        return $result->count;
    }

    public static function getGooglePlusCount($link){
        $curl = curl_init();
        $api_link = "https://clients6.google.com/rpc";
        $api_key = "AIzaSyDuFb_HOb9_6jbDD9RdQtqS65Ixs";
        curl_setopt( $curl, CURLOPT_URL, $api_link );
        curl_setopt( $curl, CURLOPT_POST, 1 );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $link . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"'.$api_key.'","apiVersion":"v1"}]' );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Content-type: application/json' ) );
        $curl_results = curl_exec( $curl );
        curl_close( $curl );
        $json = json_decode( $curl_results, true );

        return $curl_results;
    }

    public static function addAditionalData($posts){
        foreach ($posts as $post) {
            $votes = 0;
            $upvoteMatched = 0;
            $downvoteMatched = 0;
            $savedStory = 0;
            if ($post->is_link == 1) {
//                $fbCount = $this->getFacebookCount($post->link);
//                $pinCount = $this->getPinterestCount($post->link);
                $post->fb_count = 0;
                $post->pin_count = 0;

            }
            $post->description = strip_tags($post->description);

//          ---------------------  Time Calculation ------------------
            $title = preg_replace('/\s+/', '-', $post->title);
            $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
            $slug = $title . '-' . $post->id;
            $storyLink = 'story/'.$slug;

            //                    ---------------------------- Time conversion --------------------------------
            $date = PostHelper::time_elapsed_string($post->created_at, false);

//            ------------------------ upvote and downvote matching ---------------------------

            foreach($post->votes as $key=>$vote){
                $votes += $vote->vote;
            }

            if(isset(Auth::user()->id) && !empty(Auth::user()->id)){
                foreach($post->votes as $key=>$vote){
                    if($vote->user_id == Auth::user()->id && $vote->vote == 1){
                        $upvoteMatched = 1;
                        break;
                    }
                }
                foreach($post->votes as $key=>$vote){
                    if($vote->user_id == Auth::user()->id && $vote->vote == -1){
                        $downvoteMatched = 1;
                        break;
                    }
                }
                foreach($post->saved_stories as $key=>$saved){
                    if($saved->user_id == Auth::user()->id && $saved->post_id == $post->id) {
                        $savedStory = 1;
                        break;
                    }
                }
            }

            $post->upvoteMatched = $upvoteMatched;
            $post->downvoteMatched = $downvoteMatched;
            $post->savedStory = $savedStory;
            $post->vote_number = $votes;
            $post->storyLink = $storyLink;
            $post->creation_time = $date;


        }

        return $posts;

    }

    public static function filterPostQuery($posts, $filterParams,$is_end = 0){
        if($filterParams->timefilter != "none" && !$is_end){
            $filterDate = null;
            switch ($filterParams->timefilter){
                case "day" : $filterDate = date("Y-m-d");break;
                case "week" :  $filterDate = date("Y-m-d",strtotime('last Sunday'));break;
                case "month" :  $filterDate = date("Y-m-01");break;
                case "year" :  $filterDate = date("Y-01-01");break;
            }
            $posts = $posts->where('posts.created_at',">=",$filterDate);
        }

        if($filterParams->topicsfilter != "none"&& !$is_end){
            $fieldName = "is_".$filterParams->topicsfilter;
            $posts = $posts->where($fieldName,"=",1);
        }

        if($filterParams->otherfilter != "none" && $is_end){
            $posts = $posts->groupBy("posts.id");
            switch ($filterParams->otherfilter){
                case "upvote" :$posts = $posts->leftJoin("votes", "votes.post_id", "=", "posts.id")->orderByDesc(DB::raw                                    ('SUM(votes.vote)'));break;
                case "downvote" :  $posts = $posts->leftJoin("votes", "votes.post_id", "=", "posts.id")->orderBy(DB::raw                                        ('SUM(votes.vote)'));break;
                case "page-view" :  $posts = $posts->leftJoin("post_views", "post_views.post_id", "=", "posts.id")                                              ->orderByDesc(DB::raw('COUNT(post_views.id)'));break;
                case "most-comment" :  $posts = $posts->leftJoin("comments", "comments.post_id", "=", "posts.id")                                                   ->orderByDesc(DB::raw('COUNT(comments.id)'));break;
            }
        }

        return $posts;
    }

    public static function initialQueryByPage($posts, $request){
        if($request->pageKey == "story-category"){
            $searchCategory = str_replace("+", $request->searchCategory," ");
            $posts = $posts->where('category', '=', $request->searchCategory);
        }else if($request->pageKey == "story-domain"){
            $posts = $posts->where('domain', $request->searchCategory);
        }else if($request->pageKey == "story-latest"){
            $posts = $posts->orderByDesc('created_at');
        }else if($request->pageKey == "story-top"){
            $posts = $posts->leftJoin("votes", "votes.post_id", "=", "posts.id")
                ->where("votes.created_at", ">=", date("Y-m-d H:i:s", strtotime('-30 days', time())))
                ->groupBy("posts.id")
                ->orderByDesc(DB::raw("SUM(votes.vote)"));
        }else if($request->pageKey == "story-trending"){

            $posts = $posts ->leftJoin("votes", "votes.post_id", "=", "posts.id")
                ->leftJoin("comments", "comments.post_id", "=", "posts.id")
                ->leftJoin("replies", "replies.post_id", "=", "posts.id")->where(function($query) {
                    $trendingStroyFrom = SettingsHelper::getSetting('trending_story_from')->value;
                    $query->orWhere("votes.created_at", ">=", date("Y-m-d H:i:s", strtotime('-'.$trendingStroyFrom, time())))
                        ->orWhere("comments.created_at", ">=", date("Y-m-d H:i:s", strtotime('-'.$trendingStroyFrom, time())))
                        ->orWhere("replies.created_at", ">=", date("Y-m-d H:i:s", strtotime('-'.$trendingStroyFrom, time())));
                })

                ->groupBy("posts.id")
                ->orderByDesc(DB::raw("SUM(votes.vote) + COUNT(comments.id)+ COUNT(replies.id)"));
        }else if($request->pageKey == "story-popular"){
            $posts = $posts ->leftJoin("post_views", "post_views.post_id", "=", "posts.id")
                ->where("post_views.created_at", ">=", date("Y-m-d H:i:s", strtotime('-30 days', time())))
                ->groupBy("posts.id")
                ->orderByDesc(DB::raw("COUNT(post_views.id)"));
        }

        return $posts;
    }


}