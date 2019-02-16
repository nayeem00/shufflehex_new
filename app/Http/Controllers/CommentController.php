<?php

namespace App\Http\Controllers;

use App\Notifications\UserNotifications;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use App\User;
use Auth;

class CommentController extends Controller
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
//        dd($request);
        $views = Post::find($request->post_id);
        $views->post_comments += 1;
        $views->update();
        $userOfPost = User::find($views->user_id);

        $user = User::find(Auth::user()->id);
        $comment = new Comment();
        $comment->comment = $request->reply;
        $comment->post_id = $request->post_id;
        $comment->user_id = $user->id;
        $comment->username = $user->username;
        $comment->save();
        Toastr::success('comment successfully done', 'Success', ["positionClass" => "toast-top-right"]);
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
