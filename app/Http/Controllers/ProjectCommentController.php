<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Notifications\UserNotifications;
use App\ProjectComments;
use App\Project;
use App\User;
use Auth;

class ProjectCommentController extends Controller
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
        $views = Project::find($request->project_id);
        $views->project_comments += 1;
        $views->update();
        $userOfPost = User::find($views->user_id);

        $user = User::find(Auth::user()->id);
        $comment = new ProjectComments();
        $comment->comment = $request->comment;
        $comment->project_id = $request->project_id;
        $comment->user_id = $user->id;
        $comment->username = $user->username;
        $comment->save();

        $userOfPost->notify(new UserNotifications($comment));
        return back();
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
