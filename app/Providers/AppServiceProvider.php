<?php

namespace App\Providers;

use App\Post;
use App\Product;
use App\Project;
use App\Category;
use DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public $notifications;
    public function limit_text($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
    public function notificationHandler(){
        $notifications = auth()->user()->unreadNotifications;
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
                $notification->story_link = $storyLink;
                $notification->story_title = $storyTitle;
                $notification->notification = $ntf;
                $notification->user_profile_picture = $profilePicture;
                $notification->user_profile_link = $profileLink;
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
                $notification->story_link = $storyLink;
                $notification->story_title = $storyTitle;
                $notification->notification = $ntf;
                $notification->user_profile_picture = $profilePicture;
                $notification->user_profile_link = $profileLink;
            } else {
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
                $notification->story_link = $storyLink;
                $notification->story_title = $storyTitle;
                $notification->notification = $ntf;
                $notification->user_profile_picture = $profilePicture;
                $notification->user_profile_link = $profileLink;
            }
        }
        $this->notifications = $notifications;
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
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('partials.shufflebox',function($view){
            $view->with('post',Post::where('is_link',1)->with('votes')->with('comments')->with('saved_stories')->inRandomOrder()->first());
        });

        view()->composer('partials.top-bar',function($view){
            if (isset(auth()->user()->id) && !empty(auth()->user()->id)){
                $this->notificationHandler();
            }
            $view->with('notifications',$this->notifications);
        });

        view()->composer('partials.main_nav',function($view){
            if (isset(auth()->user()->id) && !empty(auth()->user()->id)){
                $this->notificationHandler();
            }
            $view->with('notifications',$this->notifications);
        });

        view()->composer('partials.list-left-sidebar',function($view){
            $categories = $this->popularTopics();
            $view->with('topics',$categories);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}