<?php

namespace App\Http\Controllers;
use App\Notifications\UserNotifications;
use Illuminate\Http\Request;

use App\Vote;
use App\ProjectVotes;
use App\ProductVote;
use App\Post;
use App\Project;
use App\Product;
use App\User;
use Auth;
use DB;

class VoteController extends Controller
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
        $views->post_votes += 1;
        $views->update();
        $userOfPost = User::find($views->user_id);

         $user = User::find($views->user_id);
         $user->elite_points += 1;
         $user->update();

        $userId = Auth::user()->id;
        $postId = $request->post_id;
        $vote =  Vote::where('user_id', $userId)
            ->where('post_id', $postId)
            ->get();
        if (isset($vote[0]) && !empty($vote[0])){
        if (isset($vote[0]->vote) && !empty($vote[0]->vote)){
            if($vote[0]->vote==1){
                $delete = Vote::find($vote[0]->id);
                $delete->delete();
                $voteNumber =  DB::table('votes')
                    ->where('post_id', $postId)
                    ->sum('vote');
                return response()->json(['stauts'=>'deleted','voteNumber' => $voteNumber]);
            }elseif ($vote[0]->vote==-1){
                $update = Vote::find($vote[0]->id);
                $update->vote = 1;
                $update->update();
                $voteNumber =  DB::table('votes')
                    ->where('post_id', $postId)
                    ->sum('vote');
                $userOfPost->notify(new UserNotifications($update));
                return response()->json(['status'=>'upvoted','voteNumber' => $voteNumber]);
            }
        }
        }else{
            $vote = new Vote();
            $vote->vote = 1;
            $vote->post_id = $postId;
            $vote->user_id = $userId;
            $vote->save();
            $voteNumber =  DB::table('votes')
                ->where('post_id', $postId)
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

    public function downVote(Request $request)
    {
        $views = Post::find($request->post_id);
        $views->post_votes -= 1;
        $views->update();
        $userOfPost = User::find($views->user_id);

        $user = User::find($views->user_id);
        $user->elite_points -= 1;
        $user->update();

        $userId = Auth::user()->id;
        $postId = $request->post_id;
        $vote =  Vote::where('user_id', $userId)
            ->where('post_id', $postId)
            ->get();

        if (isset($vote[0]) && !empty($vote[0])){
            if (isset($vote[0]->vote) && !empty($vote[0]->vote)){
                if($vote[0]->vote==-1){
                    $delete = Vote::find($vote[0]->id);
                    $delete->delete();
                    $voteNumber =  DB::table('votes')
                        ->where('post_id', $postId)
                        ->sum('vote');
                    return response()->json(['status'=>'deleted','voteNumber' => $voteNumber]);
                }elseif ($vote[0]->vote==1){
                    $update = Vote::find($vote[0]->id);
                    $update->vote = -1;
                    $update->update();
                    $userOfPost->notify(new UserNotifications($update));
                    $voteNumber =  DB::table('votes')
                        ->where('post_id', $postId)
                        ->sum('vote');
                    return response()->json(['status'=>'downvoted','voteNumber' => $voteNumber]);
                }
            }
        }else{
            $vote = new Vote();
            $vote->vote = -1;
            $vote->post_id = $postId;
            $vote->user_id = $userId;
            $vote->save();
            $userOfPost->notify(new UserNotifications($vote));
            $voteNumber =  DB::table('votes')
                ->where('post_id', $postId)
                ->sum('vote');
            return response()->json(['status'=>'downvoted','voteNumber' => $voteNumber]);
        }
    }

    public function projectUpvote(Request $request)
    {
        $views = Project::find($request->project_id);
        $views->project_votes += 1;
        $views->update();
        $userOfPost = User::find($views->user_id);

        $user = User::find($views->user_id);
        $user->elite_points += 1;
        $user->update();

        $userId = Auth::user()->id;
        $projectId = $request->project_id;
        $vote =  ProjectVotes::where('user_id', $userId)
            ->where('project_id', $projectId)
            ->get();
        if (isset($vote[0]) && !empty($vote[0])){
            if (isset($vote[0]->vote) && !empty($vote[0]->vote)){
                if($vote[0]->vote==1){
                    $delete = ProjectVotes::find($vote[0]->id);
                    $delete->delete();
                    $voteNumber =  DB::table('project_votes')
                        ->where('project_id', $projectId)
                        ->sum('vote');
                    return response()->json(['stauts'=>'deleted','voteNumber' => $voteNumber]);
                }elseif ($vote[0]->vote==-1){
                    $update = ProjectVotes::find($vote[0]->id);
                    $update->vote = 1;
                    $update->update();
                    $voteNumber =  DB::table('project_votes')
                        ->where('project_id', $projectId)
                        ->sum('vote');
                    $userOfPost->notify(new UserNotifications($update));
                    return response()->json(['status'=>'upvoted','voteNumber' => $voteNumber]);
                }
            }
        }else{
            $vote = new ProjectVotes();
            $vote->vote = 1;
            $vote->project_id = $projectId;
            $vote->user_id = $userId;
            $vote->save();
            $voteNumber =  DB::table('project_votes')
                ->where('project_id', $projectId)
                ->sum('vote');

            $userOfPost->notify(new UserNotifications($vote));
            return response()->json(['status'=>'upvoted','voteNumber' => $voteNumber]);
        }
    }

    public function projectDownvote(Request $request)
    {
        $views = Project::find($request->project_id);
        $views->project_votes -= 1;
        $views->update();
        $userOfPost = User::find($views->user_id);

        $user = User::find($views->user_id);
        $user->elite_points -= 1;
        $user->update();

        $userId = Auth::user()->id;
        $projectId = $request->project_id;
        $vote =  ProjectVotes::where('user_id', $userId)
            ->where('project_id', $projectId)
            ->get();

        if (isset($vote[0]) && !empty($vote[0])){
            if (isset($vote[0]->vote) && !empty($vote[0]->vote)){
                if($vote[0]->vote==-1){
                    $delete = ProjectVotes::find($vote[0]->id);
                    $delete->delete();
                    $voteNumber =  DB::table('project_votes')
                        ->where('project_id', $projectId)
                        ->sum('vote');
                    return response()->json(['status'=>'deleted','voteNumber' => $voteNumber]);
                }elseif ($vote[0]->vote==1){
                    $update = ProjectVotes::find($vote[0]->id);
                    $update->vote = -1;
                    $update->update();
                    $userOfPost->notify(new UserNotifications($update));
                    $voteNumber =  DB::table('project_votes')
                        ->where('project_id', $projectId)
                        ->sum('vote');
                    return response()->json(['status'=>'downvoted','voteNumber' => $voteNumber]);
                }
            }
        }else{
            $vote = new ProjectVotes();
            $vote->vote = -1;
            $vote->project_id = $projectId;
            $vote->user_id = $userId;
            $vote->save();
            $userOfPost->notify(new UserNotifications($vote));
            $voteNumber =  DB::table('project_votes')
                ->where('project_id', $projectId)
                ->sum('vote');
            return response()->json(['status'=>'downvoted','voteNumber' => $voteNumber]);
        }
    }

    public function productUpvote(Request $request)
    {
        $views = Product::find($request->product_id);
        $views->product_votes += 1;
        $views->update();
        $userOfPost = User::find($views->user_id);

        $user = User::find($views->user_id);
        $user->elite_points += 1;
        $user->update();

        $userId = Auth::user()->id;
        $productId = $request->product_id;
        $vote =  ProductVote::where('user_id', $userId)
            ->where('product_id', $productId)
            ->get();
        if (isset($vote[0]) && !empty($vote[0])){
            if (isset($vote[0]->vote) && !empty($vote[0]->vote)){
                if($vote[0]->vote==1){
                    $delete = ProductVote::find($vote[0]->id);
                    $delete->delete();
                    $voteNumber =  DB::table('product_votes')
                        ->where('product_id', $productId)
                        ->sum('vote');
                    return response()->json(['stauts'=>'deleted','voteNumber' => $voteNumber]);
                }elseif ($vote[0]->vote==-1){
                    $update = ProductVote::find($vote[0]->id);
                    $update->vote = 1;
                    $update->update();
                    $voteNumber =  DB::table('product_votes')
                        ->where('product_id', $productId)
                        ->sum('vote');
                    $userOfPost->notify(new UserNotifications($update));
                    return response()->json(['status'=>'upvoted','voteNumber' => $voteNumber]);
                }
            }
        }else{
            $vote = new ProductVote();
            $vote->vote = 1;
            $vote->product_id = $productId;
            $vote->user_id = $userId;
            $vote->save();
            $voteNumber =  DB::table('product_votes')
                ->where('product_id', $productId)
                ->sum('vote');

            $userOfPost->notify(new UserNotifications($vote));
            return response()->json(['status'=>'upvoted','voteNumber' => $voteNumber]);
        }
    }

    public function productDownvote(Request $request)
    {
        $views = Product::find($request->product_id);
        $views->product_votes -= 1;
        $views->update();
        $userOfPost = User::find($views->user_id);

        $user = User::find($views->user_id);
        $user->elite_points -= 1;
        $user->update();

        $userId = Auth::user()->id;
        $productId = $request->product_id;
        $vote =  ProductVote::where('user_id', $userId)
            ->where('product_id', $productId)
            ->get();

        if (isset($vote[0]) && !empty($vote[0])){
            if (isset($vote[0]->vote) && !empty($vote[0]->vote)){
                if($vote[0]->vote==-1){
                    $delete = ProductVote::find($vote[0]->id);
                    $delete->delete();
                    $voteNumber =  DB::table('product_votes')
                        ->where('product_id', $productId)
                        ->sum('vote');
                    return response()->json(['status'=>'deleted','voteNumber' => $voteNumber]);
                }elseif ($vote[0]->vote==1){
                    $update = ProductVote::find($vote[0]->id);
                    $update->vote = -1;
                    $update->update();
                    $userOfPost->notify(new UserNotifications($update));
                    $voteNumber =  DB::table('product_votes')
                        ->where('product_id', $productId)
                        ->sum('vote');
                    return response()->json(['status'=>'downvoted','voteNumber' => $voteNumber]);
                }
            }
        }else{
            $vote = new ProductVote();
            $vote->vote = -1;
            $vote->product_id = $productId;
            $vote->user_id = $userId;
            $vote->save();
            $userOfPost->notify(new UserNotifications($vote));
            $voteNumber =  DB::table('product_votes')
                ->where('product_id', $productId)
                ->sum('vote');
            return response()->json(['status'=>'downvoted','voteNumber' => $voteNumber]);
        }
    }
}
