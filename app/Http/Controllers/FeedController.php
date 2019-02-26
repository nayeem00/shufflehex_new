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
//        return [
//            'version' => 'https://jsonfeed.org/version/1',
//            'title' => 'ShuffleHex.com | Content Discovery Platform',
//            'home_page_url' => 'http://shufflehex.com/',
//            'feed_url' => 'https://shufflehex.com/feed',
//            'items' => []
//        ];

        $actual_link = URL::to('/');
        $icon = $actual_link."/images/icons/shufflehex.png";

        $posts = Post::where('is_publish',1)->orderByDesc('created_at')->get();

        $data = [
            'version' => 'https://jsonfeed.org/version/1',
            'title' => 'ShuffleHex.com | Content Discovery Platform',
            'home_page_url' => 'http://shufflehex.com/',
            'feed_url' => 'https://shufflehex.com/feed',
            'icon' => $icon,
            'favicon' => $icon,
            'items' => [],
        ];

        foreach ($posts as $key => $post) {
            $title = preg_replace('/\s+/', '-', $post->title);
            $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
            $title = $title . '-' . $post->id;
            $storyUrl = $actual_link.'/story/'.$title;
            $featuredImage = $actual_link.'/'.$post->featured_image;
            $user = User::find($post->user_id);
            $data['items'][$key] = [
                'id' => $post->id,
                'title' => $post->title,
                'url' => $storyUrl,
                'image' => $post->featured_image,
                'content_html' => $post->description,
                'date_created' => $post->created_at->tz('UTC')->toRfc3339String(),
                'date_modified' => $post->updated_at->tz('UTC')->toRfc3339String(),
                'author' => [
                    'name' => $user->name
                ],
            ];
        }
        return $data;
    }

}
