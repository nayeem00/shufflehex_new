<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Embed\Embed;
use App\Post;
use App\User;
use App\Category;
use Auth;
use Intervention;

class ImageController extends Controller
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
            'image'=>'required|mimes:jpg,jpeg,bmp,png,gif',
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
//        dd($request);
        $user = User::find(Auth::user()->id);
//        dd($user);
        if (Input::hasFile('image')) {
            $img = Input::file('image');
//        $img=$_FILES['image'];
            $imgName = $img->getClientOriginalName();
            if ($imgName == "") {
                echo "Select an image please!!!";
            } else {
                $image = $request->image;
                $extension =$image->getClientOriginalExtension();//get image extension only
                $imageOriginalName= $image->getClientOriginalName();
                $basename = substr($imageOriginalName, 0 , strrpos($imageOriginalName, "."));//get image name without extension
                $imageName=$basename.date("YmdHis").'.'.$extension;//make new name
                $featuredPicture = 'images/images/featured/' . $imageName;
                $imageSave = Intervention::make($image);
                $resizedImage = $imageSave->resize(650, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $save = $resizedImage->save($featuredPicture);

                $imageForStoryList = 'images/images/imagesForStoryList/'.$imageName;
                $img = Intervention::make($image);
                $resizedImage = $img->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $cropped = $resizedImage->fit(150,84);
                $save = $cropped->save($imageForStoryList);

                $imageForRelatedStory = 'images/images/imagesForRelatedStory/'.$imageName;
                $img = Intervention::make($image);
                $resizedImage = $img->resize(57, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $cropped = $resizedImage->fit(57,32);
                $save = $cropped->save($imageForRelatedStory);

                $imageForShuffleBox = 'images/images/imagesForShuffleBox/'.$imageName;
                $img = Intervention::make($image);
                $resizedImage = $img->resize(650, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $cropped = $resizedImage->fit(650,365);
                $save = $cropped->save($imageForShuffleBox);

            }
        }
        $posts = new Post();
        $posts->title = $request->title;
        $posts->featured_image = $featuredPicture;
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
        $posts->is_image = 1;
        $posts->is_video = 0;
        $posts->is_article = 0;
        $posts->is_list = 0;
        $posts->is_poll = 0;
        $posts->is_publish = 1;
        $posts->save();
        Toastr::success('Your image uploaded successfully', 'Success', ["positionClass" => "toast-top-right"]);
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
        Toastr::success('Your image info is updated successfully!', 'Success', ["positionClass" => "toast-top-right"]);
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
