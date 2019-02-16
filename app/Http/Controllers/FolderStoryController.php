<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Embed\Embed;
use App\Post;
use App\Image;
use App\User;
use App\Category;
use App\Folder;
use App\FolderStory;
use App\SavedStories;
use carbon;
use Auth;
use DB;

class FolderStoryController extends Controller
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
        $user = User::find($request->user_id);
        $info = Embed::create($request->link);

        $explodedLink = explode('//', $request->link);
        if (isset($explodedLink[1]) && !empty($explodedLink[1])) {
            $domainName = explode('/', $explodedLink[1]);
        }else {
            $domainName = explode('/', $explodedLink[0]);
        }
        $posts = new FolderStory();
        $posts->title = $info->title;
        $posts->link = $request->link;
        $posts->domain = $domainName[0];
        $posts->featured_image = $info->image;
        $posts->description = $info->description;
        $posts->user_id = $request->user_id;
        $posts->username = $user->username;
        $posts->folder_id = $request->folder_id;
        $posts->save();

        $folder = Folder::find($request->folder_id);
        $folder->updated_at = date('Y-m-d H:i:s');
        $folder->update();
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

        $folderStory = SavedStories::find($id);
//        dd($folderStory);
        $folderId = $folderStory->folder_id;
        $folderStory->delete();
        return redirect('folder/'.$folderId);
    }
}
