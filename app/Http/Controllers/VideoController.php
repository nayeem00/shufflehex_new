<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Embed\Embed;
use App\Post;
use App\Image;
use App\User;
use App\Category;
use Auth;
use Intervention;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'category'=>'required',
            'link'=>'required',
            'description'=>'required'
        ]);
        if ($request->category != '') {
            $categoryCheck = Category::where('category',$request->category)->first();
            if (!$categoryCheck){
                $category = new Category();
                $category->category = $request->category;
                $category->is_deleted = 0;
                $category->save();
            }
        }
        $user = User::find(Auth::user()->id);
        $info = Embed::create($request->link);
        $extension = pathinfo($info->image, PATHINFO_EXTENSION);
        $ext = explode('?',$extension);
        $featuredImage = 'images/videos/featured/'.str_random(4).'-'.str_slug($request->title).'-'.time().'.'.$ext[0];
//        $file = file_get_contents($info->image);
        $img = Intervention::make($info->image);
        $resizedImage = $img->resize(650, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $save = $resizedImage->save($featuredImage);

        $imageForStoryList = 'images/videos/imagesForStoryList/'.str_random(4).'-'.str_slug($request->title).'-'.time().'.'.$ext[0];
        $img = Intervention::make($info->image);
        $resizedImage = $img->resize(150, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $cropped = $resizedImage->fit(150,84);
        $save = $cropped->save($imageForStoryList);

        $imageForRelatedStory = 'images/videos/imagesForRelatedStory/'.str_random(4).'-'.str_slug($request->title).'-'.time().'.'.$ext[0];
        $img = Intervention::make($info->image);
        $resizedImage = $img->resize(57, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $cropped = $resizedImage->fit(57,32);
        $save = $cropped->save($imageForRelatedStory);

        $imageForShuffleBox = 'images/imagesByLink/imagesForShuffleBox/'.str_random(4).'-'.str_slug($request->title).'-'.time().'.'.$ext[0];
        $img = Intervention::make($info->image);
        $resizedImage = $img->resize(650, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $cropped = $resizedImage->fit(650,365);
        $save = $cropped->save($imageForShuffleBox);
        $explodedLink = explode('//', $request->link);
        if (isset($explodedLink[1]) && !empty($explodedLink[1])) {
            $domainName = explode('/', $explodedLink[1]);
        }else {
            $domainName = explode('/', $explodedLink[0]);
        }
        $domain =  str_ireplace('www.', '', $domainName[0]);
        $posts = new Post();
        $posts->title = $request->title;
        $posts->link = $request->link;
        $posts->domain = $domain;
        $posts->featured_image = $featuredImage;
        $posts->story_list_image = $imageForStoryList;
        $posts->related_story_image = $imageForRelatedStory;
        $posts->shuffle_box_image = $imageForShuffleBox;
        $posts->category = $request->category;
        $posts->description = $request->description;
        $posts->tags = $request->tags;
        $posts->user_id = $user->id;
        $posts->username = $user->username;
        $posts->views = 0;
        $posts->post_votes = 0;
        $posts->post_comments = 0;
        $posts->is_link = 0;
        $posts->is_image = 0;
        $posts->is_video = 1;
        $posts->is_article = 0;
        $posts->is_list = 0;
        $posts->is_poll = 0;
        $posts->is_publish = 1;
        $posts->save();

        Toastr::success('Your link submitted successfully', 'Success', ["positionClass" => "toast-top-right"]);
        $title = preg_replace('/\s+/', '-', $posts->title);
        $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
        $title = $title . '-' . $posts->id;

        return redirect('story/'.$title);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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
        Toastr::success('Your video info is updated successfully!', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect('story/' . $title);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
