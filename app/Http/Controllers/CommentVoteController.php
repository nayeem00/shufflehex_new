<?php

namespace App\Http\Controllers;

use App\Notifications\UserNotifications;
use Illuminate\Http\Request;

use App\Vote;
use App\CommentVote;
use App\ProjectCommentVote;
use App\Post;
use App\Project;
use App\User;
use Auth;
use DB;

class CommentVoteController extends Controller
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
        $views = Post::find($request->post_id);
        $userOfPost = User::find($views->user_id);

        $userId = Auth::user()->id;
        $postId = $request->post_id;
        $commentId = $request->comment_id;
        $vote =  CommentVote::where('user_id', $userId)
            ->where('post_id', $postId)
            ->where('comment_id', $commentId)
            ->get();
        if (isset($vote[0]) && !empty($vote[0])){
            if (isset($vote[0]->vote) && !empty($vote[0]->vote)){
                if($vote[0]->vote==1){
                    $delete = CommentVote::find($vote[0]->id);
                    $delete->delete();
                    $voteNumber =  DB::table('comment_votes')
                        ->where('post_id', $postId)
                        ->where('comment_id', $commentId)
                        ->sum('vote');
                    return response()->json(['status'=>'deleted','voteNumber' => $voteNumber]);
                }elseif ($vote[0]->vote==-1){
                    $update = CommentVote::find($vote[0]->id);
                    $update->vote = 1;
                    $update->update();
                    $voteNumber =  DB::table('comment_votes')
                        ->where('post_id', $postId)
                        ->where('comment_id', $commentId)
                        ->sum('vote');
                    $userOfPost->notify(new UserNotifications($update));
                    return response()->json(['status'=>'upvoted','voteNumber' => $voteNumber]);
                }
            }
        }else{
            $vote = new CommentVote();
            $vote->vote = 1;
            $vote->post_id = $postId;
            $vote->user_id = $userId;
            $vote->comment_id = $commentId;
            $vote->save();
            $voteNumber =  DB::table('comment_votes')
                ->where('post_id', $postId)
                ->where('comment_id', $commentId)
                ->sum('vote');

            $userOfPost->notify(new UserNotifications($vote));
            return response()->json(['status'=>'upvoted','voteNumber' => $voteNumber]);
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
        //
    }

    public function projectCommentVote(Request $request)
    {
        $views = Project::find($request->project_id);
        $userOfPost = User::find($views->user_id);

        $userId = Auth::user()->id;
        $projectId = $request->project_id;
        $commentId = $request->comment_id;
        $vote =  ProjectCommentVote::where('user_id', $userId)
            ->where('project_id', $projectId)
            ->where('comment_id', $commentId)
            ->get();
        if (isset($vote[0]) && !empty($vote[0])){
            if (isset($vote[0]->vote) && !empty($vote[0]->vote)){
                if($vote[0]->vote==1){
                    $delete = ProjectCommentVote::find($vote[0]->id);
                    $delete->delete();
                    $voteNumber =  DB::table('project_comment_votes')
                        ->where('project_id', $projectId)
                        ->where('comment_id', $commentId)
                        ->sum('vote');
                    return response()->json(['status'=>'deleted','voteNumber' => $voteNumber]);
                }elseif ($vote[0]->vote==-1){
                    $update = ProjectCommentVote::find($vote[0]->id);
                    $update->vote = 1;
                    $update->update();
                    $voteNumber =  DB::table('project_comment_votes')
                        ->where('project_id', $projectId)
                        ->where('comment_id', $commentId)
                        ->sum('vote');
                    $userOfPost->notify(new UserNotifications($update));
                    return response()->json(['status'=>'upvoted','voteNumber' => $voteNumber]);
                }
            }
        }else{
            $vote = new ProjectCommentVote();
            $vote->vote = 1;
            $vote->project_id = $projectId;
            $vote->user_id = $userId;
            $vote->comment_id = $commentId;
            $vote->save();
            $voteNumber =  DB::table('project_comment_votes')
                ->where('project_id', $projectId)
                ->where('comment_id', $commentId)
                ->sum('vote');

            $userOfPost->notify(new UserNotifications($vote));
            return response()->json(['status'=>'upvoted','voteNumber' => $voteNumber]);
        }
    }
}
