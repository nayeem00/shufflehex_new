<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Post;
use App\Project;
use App\ProjectCategory;
use App\Folder;
use Auth;
use Intervention;
use App\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {

        $this->middleware('auth', ['only' => ['create']]);
    }

    public function index()
    {
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)){
            $folders = Folder::where('user_id','=',Auth::user()->id)->get();
        }
        $posts = Project::orderBy('views', 'DESC')->orderBy('project_comments', 'DESC')->get();
        foreach ($posts as $post){
            $post->project_votes = $post->project_votes()->get();
            $post->project_comments = $post->project_comments()->get();
            $post->saved_projects = $post->saved_projects()->get();
        }
        $page = 'trending';

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/allProject', compact('posts', 'folders', 'page'));
        } else{
            return view('pages/allProject', compact('posts', 'page'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProjectCategory::get();
	    return view('pages.addProject',compact('categories'));
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
        $userId = Auth::user()->id;
        $user = User::find($userId);
        $image = $request->logo;
        $extension =$image->getClientOriginalExtension();//get image extension only
        $imageOriginalName= $image->getClientOriginalName();
        $basename = substr($imageOriginalName, 0 , strrpos($imageOriginalName, "."));//get image name without extension
        $imageName=$basename.date("YmdHis").'.'.$extension;//make new name
        $pathOfLogo = 'images/projects/logos/' . $imageName;
        $resizedImage = Intervention::make($image->getRealPath())->resize(178, 178, function ($constraint) {
            $constraint->aspectRatio();
        });
        $save = $resizedImage->save($pathOfLogo);

        $pathOfSmallLogo = 'images/projects/smallLogos/' . $imageName;
        $resizedSmallLogo = Intervention::make($image->getRealPath())->resize(84, 84, function ($constraint) {
            $constraint->aspectRatio();
        });
        $save = $resizedSmallLogo->save($pathOfSmallLogo);

//        $extension = pathinfo($request->logo, PATHINFO_EXTENSION);
//        $ext = explode('?',$extension);
//        $logo = 'images/projects/logos/'.str_random(4).'-'.str_slug($request->title).'-'.time().'.'.$ext[0];
//        $file = file_get_contents($info->image);
//        $img = Intervention::make($request->logo->getRealPath());
//        $resizedImage = $img->resize(500, 500, function ($constraint) {
//            $constraint->aspectRatio();
//        });
//        $save = $resizedImage->save($logo,60);
        $imgPaths = array();
        foreach ($request->images as $image){
            $extension =$image->getClientOriginalExtension();//get image extension only
            $imageOriginalName= $image->getClientOriginalName();
            $basename = substr($imageOriginalName, 0 , strrpos($imageOriginalName, "."));//get image name without extension
            $imageName=$basename.date("YmdHis").'.'.$extension;//make new name
            $path = 'images/projects/' . $imageName;
            $resizedImage = Intervention::make($image->getRealPath())->resize(650, 365);
            $save = $resizedImage->save($path);
            if ($save){
                $imgPaths[] = $path;
            }
        }
        $implodedPaths = implode(',',$imgPaths);

//        dd($implodedPaths);
        $project = new Project();
        $project->title = $request->title;
        $project->link = $request->link;
        $project->tag_line = $request->tag_line;
        $project->description = $request->description;
        $project->logo = $pathOfLogo;
        $project->small_logo = $pathOfSmallLogo;
        $project->screenshots = $implodedPaths;
        $project->category = $request->category;
        $project->tags = $request->tags;
        $project->user_id = $userId;
        $project->username = $user->username;
        $project->views = 0;
        $project->project_votes = 0;
        $project->project_comments = 0;
        $project->save();

        return redirect('projects');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($title)
    {
        //        $post = Post::find($id);
//        return view('pages.OldPages.iframeView', compact('post'));
        $exploded = explode('-',$title);
        $id = array_values(array_slice($exploded, -1))[0];
//        $id = substr($title, -1);
        $views = Project::find($id);
        $views->views += 1;
        $views->update();
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)){
            $userId = Auth::user()->id;
            $folders = Folder::where('user_id','=',$userId)->get();
        }

        $post = Project::find($id);
        $post->project_comments = $post->project_comments()->get();
        $post->project_replies = $post->project_replies()->get();
        $post->project_votes = $post->project_votes()->get();
        $post->saved_projects = $post->saved_projects()->get();
        $post->project_comment_votes = $post->project_comment_votes()->get();
        $post->project_comment_reply_votes = $post->project_comment_reply_votes()->get();
        $post->screenshots = explode(',',$post->screenshots);
        $tags = $post->tags;
        $category = $post->category;
        $relatedPost = Project::where('id','!=',$post->id)->where('category','=',$category)->where('tags','=',$tags)->take(3)->get();
        foreach ($relatedPost as $relPost){
            $relPost->project_votes = $relPost->project_votes();
        }
        if (count($relatedPost)<3) {
            $explodedTags = explode(',',$tags);
            foreach ($explodedTags as $tag) {
                if (count($relatedPost) < 3) {
                    $ids = array();
                    foreach ($relatedPost as $relPost){
                        $ids[] = $relPost->id;
                    }
                    $countPost = 3-count($relatedPost);
                    $related = Project::with('project_votes')->where('id', '!=', $post->id)->where('category', '=', $category)->where('tags', 'LIKE', '%' . $tag . '%')->whereNotIn('id',$ids)->take($countPost)->get();
                    if (count($relatedPost) == 0) {
                        $relatedPost = $related;
                    } else{
                        $relatedPost = $relatedPost->merge($related);
                    }
                }
            }
        }
        if (count($relatedPost)<3) {
            $ids = array();
            foreach ($relatedPost as $relPost){
                $ids[] = $relPost->id;
            }
            $countPost = 3-count($relatedPost);
            $related = Project::with('project_votes')->where('id','!=',$post->id)->where('tags','=',$tags)->whereNotIn('id',$ids)->take($countPost)->get();
            if (count($relatedPost) == 0) {
                $relatedPost = $related;
            } else{
                $relatedPost = $relatedPost->merge($related);
            }
        }

        if (count($relatedPost)<3) {
            foreach ($explodedTags as $tag) {
                if (count($relatedPost) < 3) {
                    $ids = array();
                    foreach ($relatedPost as $relPost){
                        $ids[] = $relPost->id;
                    }
                    $countPost = 3-count($relatedPost);
                    $related = Project::with('project_votes')->where('id', '!=', $post->id)->where('tags', 'LIKE', '%' . $tag . '%')->whereNotIn('id',$ids)->take($countPost)->get();
                    if (count($relatedPost) == 0) {
                        $relatedPost = $related;
                    } else{
                        $relatedPost = $relatedPost->merge($related);
                    }
                }
            }
        }
        if (count($relatedPost)<3) {
            $ids = array();
            foreach ($relatedPost as $relPost){
                $ids[] = $relPost->id;
            }
            $countPost = 3-count($relatedPost);
            $related = Project::with('project_votes')->where('id','!=',$post->id)->where('category','=',$category)->whereNotIn('id',$ids)->inRandomOrder()->take($countPost)->get();
            if (count($relatedPost) == 0) {
                $relatedPost = $related;
            } else{
                $relatedPost = $relatedPost->merge($related);
            }
        }
        if (count($relatedPost)<3) {
            $ids = array();
            foreach ($relatedPost as $relPost){
                $ids[] = $relPost->id;
            }
            $countPost = 3-count($relatedPost);
            $related = Project::with('project_votes')->where('id','!=',$post->id)->whereNotIn('id',$ids)->inRandomOrder()->take($countPost)->get();
            if (count($relatedPost) == 0) {
                $relatedPost = $related;
            } else{
                $relatedPost = $relatedPost->merge($related);
            }
        }
//        dd($relatedPost);
        $totalComments = count($post->project_comments)+count($post->project_replies);
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages.project', compact('post', 'totalComments', 'relatedPost', 'folders'));
        }else{
                return view('pages.project', compact('post', 'totalComments', 'relatedPost'));
        }
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

    public function newestProjects()
    {
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)){
            $folders = Folder::where('user_id','=',Auth::user()->id)->get();
        }
        $posts = Project::orderBy('created_at', 'DESC')->get();
        foreach ($posts as $post){
            $post->project_votes = $post->project_votes()->get();
            $post->project_comments = $post->project_comments()->get();
            $post->saved_projects = $post->saved_projects()->get();
        }
        $page = 'newest';

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/allProject', compact('posts', 'folders', 'page'));
        } else{
            return view('pages/allProject', compact('posts', 'page'));
        }
    }

    public function popularProjects()
    {
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)){
            $folders = Folder::where('user_id','=',Auth::user()->id)->get();
        }
        $posts = Project::orderBy('views', 'DESC')->get();
        foreach ($posts as $post){
            $post->project_votes = $post->project_votes()->get();
            $post->project_comments = $post->project_comments()->get();
            $post->saved_projects = $post->saved_projects()->get();
        }
        $page = 'popular';

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/allProject', compact('posts', 'folders', 'page'));
        } else{
            return view('pages/allProject', compact('posts', 'page'));
        }
    }
}
