<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Post;
use Auth;
use App\User;

class TopicController extends Controller
{
    public function index()
    {
      $topics = Category::all();

      foreach ($topics as $topic){
        $countPost = Post::where('category',$topic->category)->count('id');
        $topic->countStory = $countPost;
      }
      return view('pages/allTopics',compact('topics'));
    }

    public function findOrCreateUser( Request $user)
    {
        return response()->json(['status'=>$user->name]);
//        dd($user);
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $password = substr(str_shuffle(str_repeat($pool, 16)), 0, 16);
        $authUser = User::where('email' , $user['email'])->first();

        if(!$authUser){
//            if ($user['image'] == "") {
//            } else {
//                $image = $user['image'];
//                $extension =$image->getClientOriginalExtension();//get image extension only
//                $imageOriginalName= $image->getClientOriginalName();
//                $basename = substr($imageOriginalName, 0 , strrpos($imageOriginalName, "."));//get image name without extension
//                $imageName=$basename.date("YmdHis").'.'.$extension;//make new name
//                $profilePicture = 'images/user/profilePicture/' . $imageName;
//                $resizedImage = Intervention::make($image->getRealPath())->resize(300, 300, function ($constraint) {
//                    $constraint->aspectRatio();
//                });
//                $save = $resizedImage->save($profilePicture);
//
//                $miniProfilePicture = 'images/user/miniProfilePicture/' . $imageName;
//                $resizedImage = Intervention::make($image->getRealPath())->resize(30, 30, function ($constraint) {
//                    $constraint->aspectRatio();
//                });
//                $save = $resizedImage->save($miniProfilePicture);
//
//            }
            $user = User::create([
                'name'=> $user['name'],
                'email'=>$user['email'],
                'password' => Hash::make($password),
            ]);
            if(Auth::loginUsingId($user->id)){
                return response()->json(['status'=>'success']);
            }
        } else {
//            return redirect('/');
            if(Auth::loginUsingId($authUser->id)){
                return response()->json(['status'=>'success']);
            }
        }

    }
}
