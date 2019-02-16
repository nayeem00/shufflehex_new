<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Embed\Embed;
use App\Post;
use App\Poll;
use App\PollItem;
use App\Image;
use App\User;
use App\Category;
use App\Folder;
use App\SavedStories;
use carbon;
use Auth;
use DB;
use Intervention;


class PollItemController extends Controller
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
        $itemNames = array();
        $images = array();
        $descriptions = array();
        foreach ($request->name as $itemName){
            $itemNames[] = $itemName;
        }
        foreach ($request->description as $itemDesc){
            $descriptions[] = $itemDesc;
        }
        $user = User::find(Auth::user()->id);
        foreach ($request->images as $itemImg) {
            $image = $itemImg;
            $extension = $image->getClientOriginalExtension();//get image extension only
            $imageOriginalName = $image->getClientOriginalName();
            $basename = substr($imageOriginalName, 0, strrpos($imageOriginalName, "."));//get image name without extension
            $imageName = $basename . date("YmdHis") . '.' . $extension;//make new name
            $featuredPicture = 'images/lists/pollItems/' . $imageName;
            $imageSave = Intervention::make($image);
            $resizedImage = $imageSave->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $save = $resizedImage->save($featuredPicture);

            $images[] = $featuredPicture;
        }
        for ($i=0; $i<count($itemNames); $i++){
            $pollItem = new PollItem();
            $pollItem->title = $itemNames[$i];
            $pollItem->featured_image = $images[$i];
            $pollItem->description = $descriptions[$i];
            $pollItem->post_id = $request->post_id;
            $pollItem->user_id = $user->id;
            $pollItem->username = $user->username;
            $pollItem->item_votes = 0;
            $pollItem->save();
        }
        $post = Post::find($request->post_id);
        $post->is_publish = 1;
        $post->update();
        return redirect()->back();
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
        //
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
