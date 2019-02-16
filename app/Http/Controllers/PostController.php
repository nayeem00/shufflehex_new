<?php

namespace App\Http\Controllers;

use App\Product;
use App\Project;
use DateTime;
use Illuminate\Http\Request;
use Embed\Embed;
use App\Post;
use App\PollItem;
use App\PollVote;
use App\Image;
use App\User;
use App\Category;
use App\Folder;
use App\SavedStories;
use carbon;
use Auth;
use DB;
use Intervention;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $upvoteMatched = 0;
    public $downvoteMatched = 0;
    public $savedStory = 0;
    public $votes = 0;

    public function __construct()
    {

        $this->middleware('auth', ['only' => ['create', 'notifications']]);
    }

    public function time_elapsed_string($datetime, $full = false)
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

    public function index()
    {
//        dd(Auth::user()->id);
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $posts = Post::where('is_publish', 1)->with('votes')->with('comments')->with('saved_stories')->orderBy('views', 'DESC')->offset(0)->limit(10)->get();
        $page1 = 'all';

//        dd($posts);
        foreach ($posts as $post) {
            if ($post->is_link == 1) {
//                $fbCount = $this->getFacebookCount($post->link);
//                $pinCount = $this->getPinterestCount($post->link);
                $post->fb_count = 0;
                $post->pin_count = 0;

            }

//          ---------------------  Time Calculation ------------------

            $title = preg_replace('/\s+/', '-', $post->title);
            $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
            $title = $title . '-' . $post->id;
            $storyLink = 'story/'.$title;

            //                    ---------------------------- Time conversion --------------------------------
            $date = $this->time_elapsed_string($post->created_at, false);

//            ------------------------ upvote and downvote matching ---------------------------

            foreach($post->votes as $key=>$vote){
                $this->votes += $vote->vote;
            }

            if(isset(Auth::user()->id) && !empty(Auth::user()->id)){
                foreach($post->votes as $key=>$vote){
                    if($vote->user_id == Auth::user()->id && $vote->vote == 1){
                        $this->upvoteMatched = 1;
                        break;
                    }
                }
                foreach($post->votes as $key=>$vote){
                    if($vote->user_id == Auth::user()->id && $vote->vote == -1){
                        $this->downvoteMatched = 1;
                        break;
                    }
                }
                foreach($post->saved_stories as $key=>$saved){
                    if($saved->user_id == Auth::user()->id && $saved->post_id == $post->id) {
                        $this->savedStory = 1;
                        break;
                    }
                }
            }

            $post->upvoteMatched = $this->upvoteMatched;
            $post->downvoteMatched = $this->downvoteMatched;
            $post->savedStory = $this->savedStory;
            $post->vote_number = $this->votes;
            $post->storyLink = $storyLink;
            $post->creation_time = $date;


        }
//        dd($posts);


//        dd($result);
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/all', compact('posts', 'folders', 'page1'));
        } else {
            return view('pages/all', compact('posts', 'page1'));
        }
    }

    public function getFacebookCount($link)
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

    public function getPinterestCount($link)
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

//    public function getGooglePlusCount($link){
//        $curl = curl_init();
//        $api_link = "https://clients6.google.com/rpc";
//        $api_key = "AIzaSyDuFb_HOb9_6jbDD9RdQtqS65Ixs";
//        curl_setopt( $curl, CURLOPT_URL, $api_link );
//        curl_setopt( $curl, CURLOPT_POST, 1 );
//        curl_setopt( $curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $link . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"'.$api_key.'","apiVersion":"v1"}]' );
//        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
//        curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Content-type: application/json' ) );
//        $curl_results = curl_exec( $curl );
//        curl_close( $curl );
//        $json = json_decode( $curl_results, true );
//
//        return $curl_results;
//    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'link'=>'required',
            'category'=>'required',
            'description'=>'required'
        ]);

        $userId = Auth::user()->id;

        $user = User::find($userId);
        $info = Embed::create($request->link);
//        dd($info);
        $extension = pathinfo($info->image, PATHINFO_EXTENSION);
        $ext = explode('?', $extension);
        $featuredImage = 'images/imagesByLink/' . str_random(4) . '-' . str_slug($request->title) . '-' . time() . '.' . $ext[0];
//        $file = file_get_contents($info->image);
        $img = Intervention::make($info->image);
        $resizedImage = $img->resize(650, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $save = $resizedImage->save($featuredImage);

        $imageForStoryList = 'images/imagesByLink/imagesForStoryList/' . str_random(4) . '-' . str_slug($request->title) . '-' . time() . '.' . $ext[0];
        $img = Intervention::make($info->image);
        $resizedImage = $img->resize(150, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $cropped = $resizedImage->crop(150, 84);
        $save = $cropped->save($imageForStoryList);

        $imageForRelatedStory = 'images/imagesByLink/imagesForRelatedStory/' . str_random(4) . '-' . str_slug($request->title) . '-' . time() . '.' . $ext[0];
        $img = Intervention::make($info->image);
        $resizedImage = $img->resize(57, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $cropped = $resizedImage->crop(57, 32);
        $save = $cropped->save($imageForRelatedStory);

        $imageForShuffleBox = 'images/imagesByLink/imagesForShuffleBox/' . str_random(4) . '-' . str_slug($request->title) . '-' . time() . '.' . $ext[0];
        $img = Intervention::make($info->image);
        $resizedImage = $img->resize(650, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $cropped = $resizedImage->crop(650, 365);
        $save = $cropped->save($imageForShuffleBox);

        $explodedLink = explode('//', $request->link);
        if (isset($explodedLink[1]) && !empty($explodedLink[1])) {
            $domainName = explode('/', $explodedLink[1]);
        } else {
            $domainName = explode('/', $explodedLink[0]);
        }
        $posts = new Post();
        $posts->title = $request->title;
        $posts->link = $request->link;
        $posts->domain = $domainName[0];
        $posts->featured_image = $featuredImage;
        $posts->story_list_image = $imageForStoryList;
        $posts->related_story_image = $imageForRelatedStory;
        $posts->shuffle_box_image = $imageForShuffleBox;
        $posts->category = $request->category;
        $posts->description = $request->description;
        $posts->tags = $request->tags;
        $posts->user_id = $userId;
        $posts->username = $user->username;
        $posts->views = 0;
        $posts->post_votes = 0;
        $posts->post_comments = 0;
        $posts->is_link = 1;
        $posts->is_image = 0;
        $posts->is_video = 0;
        $posts->is_article = 0;
        $posts->is_list = 0;
        $posts->is_poll = 0;
        $posts->is_publish = 1;
        $posts->save();

        $title = preg_replace('/\s+/', '-', $posts->title);
        $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
        $title = $title . '-' . $posts->id;

        return redirect('story/' . $title);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($title)
    {
//        $post = Post::find($id);
//        return view('pages.OldPages.iframeView', compact('post'));
        $exploded = explode('-', $title);
        $id = array_values(array_slice($exploded, -1))[0];
//        $id = substr($title, -1);
        $views = Post::find($id);
        $views->views += 1;
        $views->update();
        $user = User::find($views->user_id);
        $totalViews = Post::where('user_id', $views->user_id)->sum('views');
        if ($totalViews >= 1000) {
            $totalViews = (int)($totalViews / 1000);
            $totalViews = $totalViews . 'K';
        }
//        dd($totalViews);
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $userId = Auth::user()->id;
            $folders = Folder::where('user_id', '=', $userId)->get();
        }

        $post = Post::with('comments')->with('replies')->with('votes')->with('saved_stories')->with('comment_votes')->with('comment_reply_votes')->find($id);
        $tags = $post->tags;
        $category = $post->category;
        $relatedPost = Post::with('votes')->where('id', '!=', $post->id)->where('category', '=', $category)->where('tags', '=', $tags)->take(3)->get();
        if (count($relatedPost) < 3) {
            $explodedTags = explode(',', $tags);
            foreach ($explodedTags as $tag) {
                if (count($relatedPost) < 3) {
                    $ids = array();
                    foreach ($relatedPost as $relPost) {
                        $ids[] = $relPost->id;
                    }
                    $countPost = 3 - count($relatedPost);
                    $related = Post::with('votes')->where('id', '!=', $post->id)->where('category', '=', $category)->where('tags', 'LIKE', '%' . $tag . '%')->whereNotIn('id', $ids)->take($countPost)->get();
                    if (count($relatedPost) == 0) {
                        $relatedPost = $related;
                    } else {
                        $relatedPost = $relatedPost->merge($related);
                    }
                }
            }
        }
        if (count($relatedPost) < 3) {
            $ids = array();
            foreach ($relatedPost as $relPost) {
                $ids[] = $relPost->id;
            }
            $countPost = 3 - count($relatedPost);
            $related = Post::with('votes')->where('id', '!=', $post->id)->where('tags', '=', $tags)->whereNotIn('id', $ids)->take($countPost)->get();
            if (count($relatedPost) == 0) {
                $relatedPost = $related;
            } else {
                $relatedPost = $relatedPost->merge($related);
            }
        }

        if (count($relatedPost) < 3) {
            foreach ($explodedTags as $tag) {
                if (count($relatedPost) < 3) {
                    $ids = array();
                    foreach ($relatedPost as $relPost) {
                        $ids[] = $relPost->id;
                    }
                    $countPost = 3 - count($relatedPost);
                    $related = Post::with('votes')->where('id', '!=', $post->id)->where('tags', 'LIKE', '%' . $tag . '%')->whereNotIn('id', $ids)->take($countPost)->get();
                    if (count($relatedPost) == 0) {
                        $relatedPost = $related;
                    } else {
                        $relatedPost = $relatedPost->merge($related);
                    }
                }
            }
        }
        if (count($relatedPost) < 3) {
            $ids = array();
            foreach ($relatedPost as $relPost) {
                $ids[] = $relPost->id;
            }
            $countPost = 3 - count($relatedPost);
            $related = Post::with('votes')->where('id', '!=', $post->id)->where('category', '=', $category)->whereNotIn('id', $ids)->inRandomOrder()->take($countPost)->get();
            if (count($relatedPost) == 0) {
                $relatedPost = $related;
            } else {
                $relatedPost = $relatedPost->merge($related);
            }
        }
        if (count($relatedPost) < 3) {
            $ids = array();
            foreach ($relatedPost as $relPost) {
                $ids[] = $relPost->id;
            }
            $countPost = 3 - count($relatedPost);
            $related = Post::with('votes')->where('id', '!=', $post->id)->whereNotIn('id', $ids)->inRandomOrder()->take($countPost)->get();
            if (count($relatedPost) == 0) {
                $relatedPost = $related;
            } else {
                $relatedPost = $relatedPost->merge($related);
            }
        }
//        dd($relatedPost);
        $totalComments = count($post->comments) + count($post->replies);
        if ($post->is_poll == 1 || $post->is_list == 1) {
//            $post = DB::table('posts')
//                ->join('poll_items', 'posts.id', '=', 'poll_items.post_id')
//                ->join('poll_votes', 'poll_items.id', '=', 'poll_votes.poll_item_id')
//                ->where('posts.id', $id)
//                ->where('posts.id', $id)
//                ->select('name');
//            dd($post);
            if ($post->is_poll == 1) {
                $post = Post::with(['poll_items' => function ($q) {
                    $q->orderBy('item_votes', 'desc');
                }])->find($id);
            } elseif ($post->is_list == 1) {
                $post = Post::with(['poll_items' => function ($q) {
                    $q->orderBy('id', 'asc');
                }])->find($id);
            }

            if (isset(Auth::user()->id)) {
                foreach ($post->poll_items as $onePost) {
                    $votes = PollVote::where('poll_item_id', $onePost->id)
                        ->where('user_id', Auth::user()->id)
                        ->first();

                    $onePost->poll_item_vote = $votes;
                }

            }
            foreach ($post->poll_items as $onePost) {
                $upvotes = PollVote::where('poll_item_id', $onePost->id)
                    ->where('vote', 1)
                    ->sum('vote');
                $downvotes = PollVote::where('poll_item_id', $onePost->id)
                    ->where('vote', -1)
                    ->sum('vote');

                $onePost->upvotes = $upvotes;
                $onePost->downvotes = $downvotes;
            }
            if ($post->is_publish == 1) {
                return view('pages.pollBeforePublish', compact('post'));
            } else {
                return view('pages.pollView', compact('post'));
            }
        }
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages.story', compact('post', 'totalComments', 'relatedPost', 'user', 'totalViews', 'folders'));
        } else {
            return view('pages.story', compact('post', 'totalComments', 'relatedPost', 'user', 'totalViews'));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showPost($title)
    {
        $id = substr($title, -1);
        $views = Post::find($id);
        $views->views += 1;
        $views->update();

        $post = Post::with('comments')->with('replies')->with('votes')->with('saved_stories')->find($id);
        $totalComments = count($post->comments) + count($post->replies);
        if ($post->is_poll == 1 || $post->is_list == 1) {
//            $post = DB::table('posts')
//                ->join('poll_items', 'posts.id', '=', 'poll_items.post_id')
//                ->join('poll_votes', 'poll_items.id', '=', 'poll_votes.poll_item_id')
//                ->where('posts.id', $id)
//                ->where('posts.id', $id)
//                ->select('name');
//            dd($post);
            $post = Post::with(['poll_items' => function ($q) {
                $q->orderBy('item_votes', 'desc');
            }])->find($id);

//            $post = Post::with('poll_items')->find($id);
            $poll_votes = '';
            if (isset(Auth::user()->id)) {
                foreach ($post->poll_items as $onePost) {
                    $votes = PollVote::where('poll_item_id', $onePost->id)
                        ->where('user_id', Auth::user()->id)
                        ->get();
                    foreach ($votes as $vote) {
                        $poll_votes .= $vote->poll_item_id . ',';
                    }
                }

            }
            return view('pages.pollView', compact('post', 'poll_votes'));
        }
        return view('pages.story', compact('post', 'totalComments'));
    }

    public function viewPost($title)
    {

        $exploded = explode('-', $title);
        $id = array_values(array_slice($exploded, -1))[0];
        $post = Post::with('comments')->find($id);
        return view('pages.view', compact('post'));
    }

    public function latestPost($page)
    {
//        dd($page);
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }

        $date = new Carbon\Carbon; //  DateTime string will be 2014-04-03 13:57:34

        $date->subWeek(); // or $date->subDays(7),  2014-03-27 13:58:25
        // dd($date);
        if ($page == 'all') {
            $posts = Post::with('votes')->with('comments')->where('created_at', '>=', $date->toDateTimeString())->orderBy('created_at', 'DESC')->get();
            $page1 = 'all';
            $page2 = 'Latest';
        }

        if ($page == 'web') {
            $posts = Post::with('votes')->with('comments')->where('is_link', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('created_at', 'DESC')->get();
            $page1 = 'web';
            $page2 = 'Latest';
        }

        if ($page == 'images') {
            $posts = Post::with('votes')->with('comments')->where('is_image', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('created_at', 'DESC')->get();
            $page1 = 'images';
            $page2 = 'Latest';
        }

        if ($page == 'videos') {
            $posts = Post::with('votes')->with('comments')->where('is_video', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('created_at', 'DESC')->get();
            $page1 = 'videos';
            $page2 = 'Latest';
        }


        if ($page == 'articles') {
            $posts = Post::with('votes')->with('comments')->where('is_article', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('created_at', 'DESC')->get();
            $page1 = 'articles';
            $page2 = 'Latest';
        }


        if ($page == 'lists') {
            $posts = Post::with('votes')->with('comments')->where('is_list', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('created_at', 'DESC')->get();
            $page1 = 'lists';
            $page2 = 'Latest';
        }


        if ($page == 'polls') {
            $posts = Post::with('votes')->with('comments')->where('is_poll', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('created_at', 'DESC')->get();
            $page1 = 'polls';
            $page2 = 'Latest';
        }

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/' . $page1, compact('posts', 'folders', 'page1', 'page2'));
        } else {
            return view('pages/' . $page1, compact('posts', 'page1', 'page2'));
        }

    }

    public function topPost($page)
    {
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $date = new Carbon\Carbon; //  DateTime string will be 2014-04-03 13:57:34

        $date->subWeek(); // or $date->subDays(7),  2014-03-27 13:58:25
        // dd($date);
        if ($page == 'all') {
            $posts = Post::with('votes')->with('comments')->where('created_at', '>=', $date->toDateTimeString())->orderBy('views', 'DESC')->get();
            $page1 = 'all';
            $page2 = 'Top';
        }

        if ($page == 'web') {
            $posts = Post::with('votes')->with('comments')->where('is_link', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('views', 'DESC')->get();
            $page1 = 'web';
            $page2 = 'Top';
        }

        if ($page == 'images') {
            $posts = Post::with('votes')->with('comments')->where('is_image', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('views', 'DESC')->get();
            $page1 = 'images';
            $page2 = 'Top';
        }

        if ($page == 'videos') {
            $posts = Post::with('votes')->with('comments')->where('is_video', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('views', 'DESC')->get();
            $page1 = 'videos';
            $page2 = 'Top';
        }


        if ($page == 'articles') {
            $posts = Post::with('votes')->with('comments')->where('is_article', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('views', 'DESC')->get();
            $page1 = 'articles';
            $page2 = 'Top';
        }


        if ($page == 'lists') {
            $posts = Post::with('votes')->with('comments')->where('is_list', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('views', 'DESC')->get();
            $page1 = 'lists';
            $page2 = 'Top';
        }


        if ($page == 'polls') {
            $posts = Post::with('votes')->with('comments')->where('is_poll', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('views', 'DESC')->get();
            $page1 = 'polls';
            $page2 = 'Top';
        }

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/' . $page1, compact('posts', 'folders', 'page1', 'page2'));
        } else {
            return view('pages/' . $page1, compact('posts', 'page1', 'page2'));
        }
    }

    public function popularPost($page)
    {
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $date = new Carbon\Carbon; //  DateTime string will be 2014-04-03 13:57:34

        $date->subWeek(); // or $date->subDays(7),  2014-03-27 13:58:25
        // dd($date);
        if ($page == 'all') {
            $posts = Post::with('votes')->with('comments')->where('created_at', '>=', $date->toDateTimeString())->orderBy('post_votes', 'DESC')->get();
            $page1 = 'all';
            $page2 = 'Popular';
        }

        if ($page == 'web') {
            $posts = Post::with('votes')->with('comments')->where('is_link', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('post_votes', 'DESC')->get();
            $page1 = 'web';
            $page2 = 'Popular';
        }

        if ($page == 'images') {
            $posts = Post::with('votes')->with('comments')->where('is_image', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('post_votes', 'DESC')->get();
            $page1 = 'images';
            $page2 = 'Popular';
        }

        if ($page == 'videos') {
            $posts = Post::with('votes')->with('comments')->where('is_video', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('post_votes', 'DESC')->get();
            $page1 = 'videos';
            $page2 = 'Popular';
        }


        if ($page == 'articles') {
            $posts = Post::with('votes')->with('comments')->where('is_article', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('post_votes', 'DESC')->get();
            $page1 = 'articles';
            $page2 = 'Popular';
        }


        if ($page == 'lists') {
            $posts = Post::with('votes')->with('comments')->where('is_list', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('post_votes', 'DESC')->get();
            $page1 = 'lists';
            $page2 = 'Popular';
        }


        if ($page == 'polls') {
            $posts = Post::with('votes')->with('comments')->where('is_poll', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('post_votes', 'DESC')->get();
            $page1 = 'polls';
            $page2 = 'Popular';
        }

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/' . $page1, compact('posts', 'folders', 'page1', 'page2'));
        } else {
            return view('pages/' . $page1, compact('posts', 'page1', 'page2'));
        }
    }

    public function trendingPost($page)
    {
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $date = new Carbon\Carbon; //  DateTime string will be 2014-04-03 13:57:34

        $date->subWeek(); // or $date->subDays(7),  2014-03-27 13:58:25
        // dd($date);
        if ($page == 'all') {
            $posts = Post::with('votes')->with('comments')->where('created_at', '>=', $date->toDateTimeString())->orderBy('post_votes', 'DESC')->orderBy('post_comments', 'DESC')->get();
            $page1 = 'all';
            $page2 = 'Trending';
        }

        if ($page == 'web') {
            $posts = Post::with('votes')->with('comments')->where('is_link', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('post_votes', 'DESC')->orderBy('post_comments', 'DESC')->get();
            $page1 = 'web';
            $page2 = 'Trending';
        }

        if ($page == 'images') {
            $posts = Post::with('votes')->with('comments')->where('is_image', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('post_votes', 'DESC')->orderBy('post_comments', 'DESC')->get();
            $page1 = 'images';
            $page2 = 'Trending';
        }

        if ($page == 'videos') {
            $posts = Post::with('votes')->with('comments')->where('is_video', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('post_votes', 'DESC')->orderBy('post_comments', 'DESC')->get();
            $page1 = 'videos';
            $page2 = 'Trending';
        }


        if ($page == 'articles') {
            $posts = Post::with('votes')->with('comments')->where('is_article', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('post_votes', 'DESC')->orderBy('post_comments', 'DESC')->get();
            $page1 = 'articles';
            $page2 = 'Trending';
        }


        if ($page == 'lists') {
            $posts = Post::with('votes')->with('comments')->where('is_list', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('post_votes', 'DESC')->orderBy('post_comments', 'DESC')->get();
            $page1 = 'lists';
            $page2 = 'Trending';
        }


        if ($page == 'polls') {
            $posts = Post::with('votes')->with('comments')->where('is_poll', '=', 1)->where('created_at', '>=', $date->toDateTimeString())->orderBy('post_votes', 'DESC')->orderBy('post_comments', 'DESC')->get();
            $page1 = 'polls';
            $page2 = 'Trending';
        }

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/' . $page1, compact('posts', 'folders', 'page1', 'page2'));
        } else {
            return view('pages/' . $page1, compact('posts', 'page1', 'page2'));
        }
    }

    public function webPost()
    {
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $posts = Post::with('votes')->with('comments')->with('saved_stories')->where('is_link', '=', '1')->orderBy('views', 'DESC')->get();
        $page1 = 'web';

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/web', compact('posts', 'folders', 'page1'));
        } else {
            return view('pages/web', compact('posts', 'page1'));
        }
    }

    public function imagesPost()
    {

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $posts = Post::with('votes')->with('comments')->with('saved_stories')->where('is_image', '=', '1')->orderBy('views', 'DESC')->get();
        $page1 = 'images';

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/images', compact('posts', 'folders', 'page1'));
        } else {
            return view('pages/images', compact('posts', 'page1'));
        }
    }


    public function videosPost()
    {

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $posts = Post::with('votes')->with('comments')->with('saved_stories')->where('is_video', '=', '1')->orderBy('views', 'DESC')->get();
        $page1 = 'videos';

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/videos', compact('posts', 'folders', 'page1'));
        } else {
            return view('pages/videos', compact('posts', 'page1'));
        }
    }


    public function articlesPost()
    {

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $posts = Post::with('votes')->with('comments')->with('saved_stories')->where('is_article', '=', '1')->orderBy('views', 'DESC')->get();
        $page1 = 'articles';

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/articles', compact('posts', 'folders', 'page1'));
        } else {
            return view('pages/articles', compact('posts', 'page1'));
        }
    }


    public function listsPost()
    {

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $posts = Post::with('votes')->with('comments')->with('saved_stories')->where('is_list', '=', '1')->orderBy('views', 'DESC')->get();
        $page1 = 'lists';

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/lists', compact('posts', 'folders', 'page1'));
        } else {
            return view('pages/lists', compact('posts', 'page1'));
        }
    }


    public function pollsPost()
    {

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $posts = Post::with('votes')->with('comments')->with('saved_stories')->where('is_poll', '=', '1')->orderBy('views', 'DESC')->get();
        $page1 = 'polls';

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/polls', compact('posts', 'folders', 'page1'));
        } else {
            return view('pages/polls', compact('posts', 'page1'));
        }
    }


    public function savedPost()
    {
        $userId = Auth::user()->id;
        $folders = Folder::where('user_id', '=', $userId)->get();
//        dd($folders);
        $savedPosts = DB::table('posts')->join('saved_stories', 'posts.id', '=', 'saved_stories.post_id')->where('saved_stories.user_id', '=', $userId)->get();
//        $savedPosts = SavedStories::with('posts')->where('user_id','=',$userId)->orderBy('created_at', 'DESC')->get();

        return view('pages/saved', compact('savedPosts', 'folders'));
    }

    public function limit_text($text, $limit)
    {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }

    public function notifications()
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);
        $notifications = auth()->user()->Notifications;
//        dd($notifications);
        foreach ($notifications as $notification) {
            if (array_key_exists('product_id', $notification->data['data'])) {

                if (array_key_exists('review_comment', $notification->data['data'])) {
                    $post = Product::find($notification->data['data']['product_id']);
                    $storyTitle = $this->limit_text($post->product_name, 5);
                    $title = preg_replace('/\s+/', '-', $post->product_name);
                    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
                    $title = $title . '-' . $post->id;
                    $storyLink = 'product/' . $title;
                    $ntf = '<strong>' . $notification->data['user']['name'] . '</strong> reviewed your product';
                    $profileLink = 'profile/' . $notification->data['user']['username'];
                    if (!empty($notification->data['user']['mini_profile_picture_link'])) {
                        $profilePicture = $notification->data['user']['mini_profile_picture_link'];
                    } else {
                        $profilePicture = 'images/user/profilePicture/default/user.png';
                    }
                } elseif (array_key_exists('vote', $notification->data['data']) && $notification->data['data']['vote'] == 1) {
                    $post = Product::find($notification->data['data']['product_id']);
                    $storyTitle = $this->limit_text($post->product_name, 5);
                    $title = preg_replace('/\s+/', '-', $post->product_name);
                    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
                    $title = $title . '-' . $post->id;
                    $storyLink = 'product/' . $title;
                    $ntf = '<strong>' . $notification->data['user']['name'] . '</strong> upvoted your product';
                    $profileLink = 'profile/' . $notification->data['user']['username'];
                    if (!empty($notification->data['user']['mini_profile_picture_link'])) {
                        $profilePicture = $notification->data['user']['mini_profile_picture_link'];
                    } else {
                        $profilePicture = 'images/user/profilePicture/default/user.png';
                    }
                } elseif (array_key_exists('vote', $notification->data['data']) && $notification->data['data']['vote'] == -1) {
                    $post = Product::find($notification->data['data']['product_id']);
                    $storyTitle = $this->limit_text($post->product_name, 5);
                    $title = preg_replace('/\s+/', '-', $post->product_name);
                    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
                    $title = $title . '-' . $post->id;
                    $storyLink = 'product/' . $title;
                    $ntf = '<strong>' . $notification->data['user']['name'] . '</strong> downvoted your product';
                    $profileLink = 'profile/' . $notification->data['user']['username'];
                    if (!empty($notification->data['user']['mini_profile_picture_link'])) {
                        $profilePicture = $notification->data['user']['mini_profile_picture_link'];
                    } else {
                        $profilePicture = 'images/user/profilePicture/default/user.png';
                    }
                }
            } elseif (array_key_exists('project_id', $notification->data['data'])) {
                if (array_key_exists('comment', $notification->data['data']) || array_key_exists('reply', $notification->data['data'])) {
                    $post = Project::find($notification->data['data']['project_id']);
                    $storyTitle = $this->limit_text($post->title, 5);
                    $title = preg_replace('/\s+/', '-', $post->title);
                    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
                    $title = $title . '-' . $post->id;
                    $storyLink = 'project/' . $title;
                    $ntf = '<strong>' . $notification->data['user']['name'] . '</strong> commented on your project';
                    $profileLink = 'profile/' . $notification->data['user']['username'];
                    if (!empty($notification->data['user']['mini_profile_picture_link'])) {
                        $profilePicture = $notification->data['user']['mini_profile_picture_link'];
                    } else {
                        $profilePicture = 'images/user/profilePicture/default/user.png';
                    }
                } elseif (array_key_exists('vote', $notification->data['data']) && $notification->data['data']['vote'] == 1) {
                    $post = Project::find($notification->data['data']['project_id']);
                    $storyTitle = $this->limit_text($post->title, 5);
                    $title = preg_replace('/\s+/', '-', $post->title);
                    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
                    $title = $title . '-' . $post->id;
                    $storyLink = 'story/' . $title;
                    $ntf = '<strong>' . $notification->data['user']['name'] . '</strong> upvoted your project';
                    $profileLink = 'profile/' . $notification->data['user']['username'];
                    if (!empty($notification->data['user']['mini_profile_picture_link'])) {
                        $profilePicture = $notification->data['user']['mini_profile_picture_link'];
                    } else {
                        $profilePicture = 'images/user/profilePicture/default/user.png';
                    }
                } elseif (array_key_exists('vote', $notification->data['data']) && $notification->data['data']['vote'] == -1) {
                    $post = Project::find($notification->data['data']['project_id']);
                    $storyTitle = $this->limit_text($post->title, 5);
                    $title = preg_replace('/\s+/', '-', $post->title);
                    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
                    $title = $title . '-' . $post->id;
                    $storyLink = 'project/' . $title;
                    $ntf = '<strong>' . $notification->data['user']['name'] . '</strong> downvoted your project';
                    $profileLink = 'profile/' . $notification->data['user']['username'];
                    if (!empty($notification->data['user']['mini_profile_picture_link'])) {
                        $profilePicture = $notification->data['user']['mini_profile_picture_link'];
                    } else {
                        $profilePicture = 'images/user/profilePicture/default/user.png';
                    }
                }
            } elseif (array_key_exists('post_id', $notification->data['data'])) {
                if (array_key_exists('comment', $notification->data['data']) || array_key_exists('reply', $notification->data['data'])) {
                    $post = Post::find($notification->data['data']['post_id']);
                    $storyTitle = $this->limit_text($post->title, 5);
                    $title = preg_replace('/\s+/', '-', $post->title);
                    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
                    $title = $title . '-' . $post->id;
                    $storyLink = 'story/' . $title;
                    $ntf = '<strong>' . $notification->data['user']['name'] . '</strong> commented on your story';
                    $profileLink = 'profile/' . $notification->data['user']['username'];
                    if (!empty($notification->data['user']['mini_profile_picture_link'])) {
                        $profilePicture = $notification->data['user']['mini_profile_picture_link'];
                    } else {
                        $profilePicture = 'images/user/profilePicture/default/user.png';
                    }
                } elseif (array_key_exists('vote', $notification->data['data']) && $notification->data['data']['vote'] == 1) {
                    $post = Post::find($notification->data['data']['post_id']);
                    $storyTitle = $this->limit_text($post->title, 5);
                    $title = preg_replace('/\s+/', '-', $post->title);
                    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
                    $title = $title . '-' . $post->id;
                    $storyLink = 'story/' . $title;
                    $ntf = '<strong>' . $notification->data['user']['name'] . '</strong> upvoted your story';
                    $profileLink = 'profile/' . $notification->data['user']['username'];
                    if (!empty($notification->data['user']['mini_profile_picture_link'])) {
                        $profilePicture = $notification->data['user']['mini_profile_picture_link'];
                    } else {
                        $profilePicture = 'images/user/profilePicture/default/user.png';
                    }
                } elseif (array_key_exists('vote', $notification->data['data']) && $notification->data['data']['vote'] == -1) {
                    $post = Post::find($notification->data['data']['post_id']);
                    $storyTitle = $this->limit_text($post->title, 5);
                    $title = preg_replace('/\s+/', '-', $post->title);
                    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
                    $title = $title . '-' . $post->id;
                    $storyLink = 'story/' . $title;
                    $ntf = '<strong>' . $notification->data['user']['name'] . '</strong> downvoted your story';
                    $profileLink = 'profile/' . $notification->data['user']['username'];
                    if (!empty($notification->data['user']['mini_profile_picture_link'])) {
                        $profilePicture = $notification->data['user']['mini_profile_picture_link'];
                    } else {
                        $profilePicture = 'images/user/profilePicture/default/user.png';
                    }
                }
            }
            $notification->story_link = $storyLink;
            $notification->story_title = $storyTitle;
            $notification->notification = $ntf;
            $notification->user_profile_picture = $profilePicture;
            $notification->user_profile_link = $profileLink;
        }

        return view('pages/user/notifications', compact('notifications','user'));
    }

    public function userWisePosts($username)
    {
//        dd(Auth::user()->id);
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $posts = Post::with('votes')->with('comments')->with('saved_stories')->where('username', '=', $username)->orderBy('views', 'DESC')->get();
        $user = User::where('username', $username)->first();
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/user/userWisePosts', compact('posts', 'user', 'folders'));
        } else {
            return view('pages/user/userWisePosts', compact('posts', 'user'));
        }
    }


    public function domainWisePosts($domain)
    {
//        dd(Auth::user()->id);
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $posts = Post::with('votes')->with('comments')->with('saved_stories')->where('domain', $domain)->orderBy('views', 'DESC')->get();

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/domainWisePosts', compact('posts', 'folders', 'domain'));
        } else {
            return view('pages/domainWisePosts', compact('posts', 'domain'));
        }
    }


}
