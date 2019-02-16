<?php

namespace App\Http\Controllers;

use App\Folder;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class FolderController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$user = User::find($request->user_id);
		$folders = new Folder();
		$folders->folder_name = $request->folder_name;
		$folders->user_id = $request->user_id;
		$folders->username = $user->username;
		$folders->save();

		return redirect('saved');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
//        dd($id);
		$folder = Folder::find($id);
		$folderStories = DB::table('folders')
			->join('saved_stories', 'saved_stories.folder_id', '=', 'folders.id')
			->join('posts', 'posts.id', '=', 'saved_stories.post_id')
			->where('folders.id', '=', $id)
			->select('saved_stories.id as saved_id', 'saved_stories.user_id', 'saved_stories.post_id', 'saved_stories.folder_id', 'posts.title', 'posts.story_list_image', 'folders.folder_name')
			->get();
//        dd($folderStories);

		return view('pages/folderWiseStories', compact('folderStories', 'folder'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$folders = Folder::find($id);
		return response()->json(['status' => 'found', 'data' => $folders]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
//        $folders = Folder::find($request->folder_id);
		//        $folders->folder_name = $request->folder_name;
		//        $folders->update();
		return response()->json(['status' => 'updated', 'data' => $request->folder_id]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}

	public function updateFolder(Request $request) {
		$folders = Folder::find($request->folder_id);
		$folders->folder_name = $request->folder_name;
		$folders->update();
		return response()->json(['status' => 'updated', 'data' => $request->folder_name]);
	}

	public function deleteFolder(Request $request) {
		$folder = Folder::find($request->folder_id);
		$folder->delete();
		return response()->json(['status' => 'updated', 'data' => $folder]);
	}

	public function allFolders() {
		$userId = Auth::user()->id;
		$folders = Folder::where('user_id', '=', $userId)->get();
//        dd($folders);
		$savedPosts = DB::table('posts')->join('saved_stories', 'posts.id', '=', 'saved_stories.post_id')->where('saved_stories.user_id', '=', $userId)->get();
//        $savedPosts = SavedStories::with('posts')->where('user_id','=',$userId)->orderBy('created_at', 'DESC')->get();

		return view('pages/folders', compact('savedPosts', 'folders'));
	}
}
