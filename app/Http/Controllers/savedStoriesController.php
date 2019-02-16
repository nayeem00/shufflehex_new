<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SavedStories;
use App\Post;
use App\FolderStory;
use Auth;
use DB;

class savedStoriesController extends Controller
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
        $userId = Auth::user()->id;
        $postId = $request->post_id;
//        $folderId = $request->folder_id;
        $savedStory =  SavedStories::where('user_id', $userId)
            ->where('post_id', $postId)
            ->get();

        if (isset($savedStory[0]) && !empty($savedStory[0])){
                    $delete = SavedStories::find($savedStory[0]->id);
                    $delete->delete();
                    return response()->json(['status'=>'deleted']);
            }elseif(isset($request->folder_id) && !empty($request->folder_id)){
            $savedStory = new SavedStories();
            $savedStory->post_id = $postId;
            $savedStory->user_id = $userId;
            $savedStory->folder_id = $request->folder_id;
            $savedStory->save();
            return response()->json(['status'=>'saved']);
        } else{
            return response()->json(['status'=>'showModal']);
        }

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
        $savedStory = SavedStories::find($id);
        $savedStory->delete();
        return redirect('saved');
    }
}
