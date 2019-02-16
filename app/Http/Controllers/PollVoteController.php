<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PollVote;
use App\PollItem;
use Auth;
use DB;

class PollVoteController extends Controller
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
        $postId = $request->poll_item_id;
        $vote =  PollVote::where('user_id', $userId)
            ->where('poll_item_id', $postId)
            ->first();
        if (isset($vote) && !empty($vote)){
            if (isset($vote->vote) && !empty($vote->vote)){
                if($vote->vote==1){
                    $delete = PollVote::find($vote->id);
                    $delete->delete();
                    $totalVotes =  DB::table('poll_votes')
                        ->where('poll_item_id', $postId)
                        ->sum('vote');
                    $views = PollItem::find($request->poll_item_id);
                    $views->item_votes = $totalVotes;
                    $views->update();
                    $upvote =  DB::table('poll_votes')
                        ->where('poll_item_id', $postId)
                        ->where('vote', 1)
                        ->sum('vote');
                    $downvote =  DB::table('poll_votes')
                        ->where('poll_item_id', $postId)
                        ->where('vote', -1)
                        ->sum('vote');
                    return response()->json(['status'=>'deleted','upvote' => $upvote,'downvote' => $downvote]);
                }elseif ($vote->vote==-1){
                    $update = PollVote::find($vote->id);
                    $update->vote = 1;
                    $update->update();
                    $totalVotes =  DB::table('poll_votes')
                        ->where('poll_item_id', $postId)
                        ->sum('vote');
                    $views = PollItem::find($request->poll_item_id);
                    $views->item_votes = $totalVotes;
                    $views->update();
                    $upvote =  DB::table('poll_votes')
                        ->where('poll_item_id', $postId)
                        ->where('vote', 1)
                        ->sum('vote');
                    $downvote =  DB::table('poll_votes')
                        ->where('poll_item_id', $postId)
                        ->where('vote', -1)
                        ->sum('vote');
                    return response()->json(['status'=>'upvoted','upvote' => $upvote,'downvote' => $downvote]);
                }
            }
        }else{
            $vote = new PollVote();
            $vote->vote = 1;
            $vote->poll_item_id = $postId;
            $vote->user_id = $userId;
            $vote->save();
            $totalVotes =  DB::table('poll_votes')
                ->where('poll_item_id', $postId)
                ->sum('vote');
            $views = PollItem::find($request->poll_item_id);
            $views->item_votes = $totalVotes;
            $views->update();
            $upvote =  DB::table('poll_votes')
                ->where('poll_item_id', $postId)
                ->where('vote', 1)
                ->sum('vote');
            $downvote =  DB::table('poll_votes')
                ->where('poll_item_id', $postId)
                ->where('vote', -1)
                ->sum('vote');
            return response()->json(['status'=>'upvoted','upvote' => $upvote,'downvote' => $downvote]);
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

    public function downvote(Request $request)
    {

        $userId = Auth::user()->id;
        $postId = $request->poll_item_id;
        $vote =  PollVote::where('user_id', $userId)
            ->where('poll_item_id', $postId)
            ->first();
        if (isset($vote) && !empty($vote)){
            if (isset($vote->vote) && !empty($vote->vote)){
                if($vote->vote==1){
                    $vote->vote = -1;
                    $vote->update();
                    $totalVotes =  DB::table('poll_votes')
                        ->where('poll_item_id', $postId)
                        ->sum('vote');
                    $views = PollItem::find($request->poll_item_id);
                    $views->item_votes = $totalVotes;
                    $views->update();
                    $upvote =  DB::table('poll_votes')
                        ->where('poll_item_id', $postId)
                        ->where('vote', 1)
                        ->sum('vote');
                    $downvote =  DB::table('poll_votes')
                        ->where('poll_item_id', $postId)
                        ->where('vote', -1)
                        ->sum('vote');
                    return response()->json(['status'=>'downvoted','upvote' => $upvote,'downvote' => $downvote]);
                }elseif ($vote->vote==-1){
                    $vote->delete();
                    $totalVotes =  DB::table('poll_votes')
                        ->where('poll_item_id', $postId)
                        ->sum('vote');
                    $views = PollItem::find($request->poll_item_id);
                    $views->item_votes = $totalVotes;
                    $views->update();
                    $upvote =  DB::table('poll_votes')
                        ->where('poll_item_id', $postId)
                        ->where('vote', 1)
                        ->sum('vote');
                    $downvote =  DB::table('poll_votes')
                        ->where('poll_item_id', $postId)
                        ->where('vote', -1)
                        ->sum('vote');
                    return response()->json(['status'=>'deleted','upvote' => $upvote,'downvote' => $downvote]);
                }
            }
        }else{
            $vote = new PollVote();
            $vote->vote = -1;
            $vote->poll_item_id = $postId;
            $vote->user_id = $userId;
            $vote->save();
            $totalVotes =  DB::table('poll_votes')
                ->where('poll_item_id', $postId)
                ->sum('vote');
            $views = PollItem::find($request->poll_item_id);
            $views->item_votes = $totalVotes;
            $views->update();
            $upvote =  DB::table('poll_votes')
                ->where('poll_item_id', $postId)
                ->where('vote', 1)
                ->sum('vote');
            $downvote =  DB::table('poll_votes')
                ->where('poll_item_id', $postId)
                ->where('vote', -1)
                ->sum('vote');
            return response()->json(['status'=>'downvoted','upvote' => $upvote,'downvote' => $downvote]);
        }
    }
}
