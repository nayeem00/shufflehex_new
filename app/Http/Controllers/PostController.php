<?php

namespace App\Http\Controllers;

use App\Http\PostHelper;
use App\Http\SettingsHelper;
use App\Product;
use App\Project;
use App\Settings;
use Brian2694\Toastr\Facades\Toastr;
use DateTime;
use Illuminate\Http\Request;
use Embed\Embed;
use App\Post;
use App\PostView;
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
use Illuminate\Support\Facades\File;
use Intervention;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {

        $this->middleware('auth', ['only' => ['create', 'notifications', 'edit', 'update','destroy']]);
    }

    public function popularTopics(){
        $categories = Category::select('categories.*')->leftJoin("post_views", "post_views.category_id", "=", "categories.id")
            ->where("post_views.created_at", ">=", date("Y-m-d H:i:s", strtotime('-24 hours', time())))
            ->groupBy("categories.id")
            ->orderByDesc(DB::raw('COUNT(post_views.view)'))
            ->limit(5)
            ->get();
//        dd($categories);
        return $categories;
    }

    public function index()
    {
//        dd(Auth::user()->id);
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $postLimit = SettingsHelper::getSetting('story_limit');
        $posts = Post::where('is_publish', 1)->with('votes')->with('comments')->with('saved_stories')->orderBy('views', 'DESC')->offset(0)->limit($postLimit->value)->get();
        $page1 = 'all';

//        dd($posts);

//        dd($posts);
        $pageKey = "story-main";

        $posts = PostHelper::addAditionalData($posts);
//        dd($result);
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/all', compact('posts', 'folders', 'pageKey'));
        } else {
            return view('pages/all', compact('posts', 'page1','pageKey'));
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->popularTopics();
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
        $posts->slug = str_slug($request->title);
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
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $client_ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $client_ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $client_ip=$_SERVER['REMOTE_ADDR'];
        }
//        $post = Post::find($id);
//        return view('pages.OldPages.iframeView', compact('post'));
        $exploded = explode('-', $title);
        $id = array_values(array_slice($exploded, -1))[0];
//        $id = substr($title, -1);
        $views = Post::find($id);
        $views->views += 1;
        $views->update();
//        dd($views);
        $category = Category::where('category',$views->category)->first();
        $postUser = User::find($views->user_id);
        $totalViews = PostView::where('user_id', $views->user_id)->sum('view');
        $thisStoryViews = PostView::where('post_id', $views->id)->sum('view');
        if ($totalViews >= 1000) {
            $totalViews = (int)($totalViews / 1000);
            $totalViews = $totalViews . 'K';
        }
        $postView = new PostView();
        $postView->view = 1;
        $postView->client_ip = $client_ip;
        $postView->post_id = $id;
        $postView->category_id = $category->id;
        $postView->user_id = $postUser->id;
        $postView->save();
//        dd($totalViews);
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $userId = Auth::user()->id;
            $folders = Folder::where('user_id', '=', $userId)->get();
        }

        $post = Post::with('comments')->with('replies')->with('votes')->with('saved_stories')->with('comment_votes')->with('comment_reply_votes')->find($id);
        foreach ($post->comments as $comment){
            $commentUser = User::find($comment->user_id);
            $comment->user = $commentUser;
        }
        foreach ($post->replies as $reply){
            $replyUser = User::find($reply->user_id);
            $reply->user = $replyUser;
        }
        $post->views = $thisStoryViews;
        $post->metaDescription = substr($post->description, 0, 160);
        $post->metaDescription .= '...';
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
                if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
                    return view('pages.pollView', compact('post', 'totalComments', 'relatedPost', 'postUser', 'totalViews', 'folders'));
                } else {
                    return view('pages.pollView', compact('post', 'totalComments', 'relatedPost', 'postUser', 'totalViews'));
                }
            } else {
                if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
                    return view('pages.pollBeforePublish', compact('post', 'totalComments', 'relatedPost', 'postUser', 'totalViews', 'folders'));
                } else {
                    return view('pages.pollBeforePublish', compact('post', 'totalComments', 'relatedPost', 'postUser', 'totalViews'));
                }
            }
        }
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages.story', compact('post', 'totalComments', 'relatedPost', 'postUser', 'totalViews', 'folders'));
        } else {
            return view('pages.story', compact('post', 'totalComments', 'relatedPost', 'postUser', 'totalViews'));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($title)
    {
        $exploded = explode('-', $title);
        $postId = array_values(array_slice($exploded, -1))[0];
        $post = Post::find($postId);
        if ($post->user_id ==Auth::user()->id ){
            $categories = $this->popularTopics();
            return view('pages.edit', compact('post','categories'));
        } else{
            return redirect()->back();
        }
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
        $this->validate($request,[
            'title'=>'required',
            'category'=>'required',
            'description'=>'required'
        ]);
        $post = Post::find($id);
        $post->title = $request->title;
        $post->category = $request->category;
        $post->description = $request->description;
        $post->tags = $request->tags;
        $post->update();

        $title = preg_replace('/\s+/', '-', $post->title);
        $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
        $title = $title . '-' . $post->id;
        Toastr::success('Your story is updated successfully!', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect('story/' . $title);
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

    public function latestPost()
    {
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $postLimit = SettingsHelper::getSetting('story_limit');
        $posts = Post::with('votes')->where('is_publish', 1)->with('comments')->with('saved_stories')->orderByDesc('created_at')->offset(0)->limit($postLimit->value)->get();

        $page = 'Latest';
        $posts = PostHelper::addAditionalData($posts);
        $pageKey = "story-latest";

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/latest', compact('posts', 'folders', 'page','pageKey'));
        } else {
            return view('pages/latest', compact('posts', 'page','pageKey'));
        }
    }

    public function topPost()
    {
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $postLimit = SettingsHelper::getSetting('story_limit');
        $posts = Post::select('posts.*')->where('is_publish', 1)->with('votes')->with('comments')->with('saved_stories')
            ->leftJoin("votes", "votes.post_id", "=", "posts.id")
            ->where("votes.created_at", ">=", date("Y-m-d H:i:s", strtotime('-30 days', time())))
            ->groupBy("posts.id")
            ->orderByDesc(DB::raw("SUM(votes.vote)"))
            ->offset(0)
            ->limit($postLimit->value)
            ->get();
        $page = 'Top';
        $pageKey = "story-top";
        $posts = PostHelper::addAditionalData($posts);
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/top' , compact('posts', 'folders', 'page','pageKey'));
        } else {
            return view('pages/top', compact('posts', 'page','pageKey'));
        }
    }

    public function popularPost()
    {
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $postLimit = SettingsHelper::getSetting('story_limit');
        $posts = Post::select('posts.*')->where('is_publish', 1)->with('votes')->with('comments')->with('saved_stories')
            ->leftJoin("post_views", "post_views.post_id", "=", "posts.id")
            ->where("post_views.created_at", ">=", date("Y-m-d H:i:s", strtotime('-30 days', time())))
            ->groupBy("posts.id")
            ->orderByDesc(DB::raw("COUNT(post_views.id)"))
            ->offset(0)
            ->limit($postLimit->value)
            ->get();
        $page = 'Popular';
        $pageKey = "story-popular";
        $posts = PostHelper::addAditionalData($posts);
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/popular' , compact('posts', 'folders', 'page','pageKey'));
        } else {
            return view('pages/popular', compact('posts', 'page','pageKey'));
        }
    }

    public function trendingPost()
    {
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }

        $postLimit = SettingsHelper::getSetting('story_limit');
        $trendingStroyFrom = SettingsHelper::getSetting('trending_story_from')->value;
        $posts = Post::select('posts.*')->where('is_publish', 1)->with('votes')->with('comments')->with('saved_stories')
            ->leftJoin("votes", "votes.post_id", "=", "posts.id")
            ->leftJoin("comments", "comments.post_id", "=", "posts.id")
            ->leftJoin("replies", "replies.post_id", "=", "posts.id")
            ->where("votes.created_at", ">=", date("Y-m-d H:i:s", strtotime('-'.$trendingStroyFrom, time())))
            ->orWhere("comments.created_at", ">=", date("Y-m-d H:i:s", strtotime('-'.$trendingStroyFrom, time())))
            ->orWhere("replies.created_at", ">=", date("Y-m-d H:i:s", strtotime('-'.$trendingStroyFrom, time())))
            ->groupBy("posts.id")
//            ->orderBy(DB::raw('SUM(votes.vote)'))
            ->orderByDesc(DB::raw("SUM(votes.vote) + COUNT(comments.id)+ COUNT(replies.id)"))
            ->offset(0)
            ->limit($postLimit->value)
            ->get();
            $page = 'Trending';
            $posts = PostHelper::addAditionalData($posts);
//        dd($posts);
        $pageKey = "story-trending";
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/trending' , compact('posts', 'folders', 'page','pageKey'));
        } else {
            return view('pages/trending', compact('posts', 'page','pageKey'));
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
        $postLimit = SettingsHelper::getSetting('story_limit');
        $posts = Post::with('votes')->with('comments')->with('saved_stories')->where('username', '=', $username)->orderBy('views', 'DESC')->offset(0)->limit($postLimit->value)->get();
        $user = User::where('username', $username)->first();
        $pageKey = "story-user";

        $posts = PostHelper::addAditionalData($posts);

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/user/userWisePosts', compact('posts', 'user', 'folders', 'pageKey'));
        } else {
            return view('pages/user/userWisePosts', compact('posts', 'user', 'pageKey'));
        }
    }


    public function domainWisePosts($domain)
    {
//        dd(Auth::user()->id);
        $info = Embed::create('http://'.$domain);
        $metaDescription = $info->description;
        $metaTitle = $info->title;
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            $folders = Folder::where('user_id', '=', Auth::user()->id)->get();
        }
        $postLimit = SettingsHelper::getSetting('story_limit');
        $posts = Post::with('votes')->with('comments')->with('saved_stories') ->where('is_publish', 1)->where('domain', $domain)->orderBy('views', 'DESC')->offset(0)->limit($postLimit->value)->get();


        $pageKey = "story-domain";

        $posts = PostHelper::addAditionalData($posts);

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/domainWisePosts', compact('posts', 'folders', 'domain', 'pageKey', 'metaDescription', 'metaTitle'));
        } else {
            return view('pages/domainWisePosts', compact('posts', 'domain', 'pageKey', 'metaDescription', 'metaTitle'));
        }
    }

    public function generateContentFromUrl(Request $request){
        $info = Embed::create($request->link);
        return response()->json(['title'=>$info->title,'description' => $info->description]);
    }


}
