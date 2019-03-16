<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Product;
use App\ProductSetting;
use App\ProductStore;
use App\Image;
use App\User;
use App\ProductCategory;
use App\Folder;
use App\SavedStories;
use carbon;
use Auth;
use DB;
use Illuminate\Support\Facades\File;
use Intervention;
use Redirect;

class ProductController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth', ['only' => ['create']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)){
            $folders = Folder::where('user_id','=',Auth::user()->id)->get();
        }
        $posts = Product::orderBy('views', 'DESC')->orderBy('product_review', 'DESC')->get();
        foreach ($posts as $post){
            $post->product_votes = $post->product_votes()->get();
            $post->product_reviews = $post->product_reviews()->get();
            $post->saved_products = $post->saved_products()->get();
        }
        $page = 'trending';

        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages/allProduct', compact('posts', 'folders', 'page'));
        } else{
            return view('pages/allProduct', compact('posts', 'page'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::get();
        $stores = ProductStore::all();
        return view('pages.addProduct', compact('categories', 'stores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'product_name'=>'required',
            'img'=>'required',
            'short_desc'=>'required',
            'category'=>'required',
            'price'=>'required',
            'desc'=>'required'
        ]);
        $userId = Auth::user()->id;

        $user = User::find($userId);
        $store = $request->store;
        $productId = $request->productId;
        $storeInfo = ProductStore::where('store_name',$store)->first();
        $productUrl = $storeInfo->store_prefix.$productId;

        $image = $request->img[0];
        $extension =$image->getClientOriginalExtension();//get image extension only
        $imageOriginalName= $image->getClientOriginalName();
        $basename = substr($imageOriginalName, 0 , strrpos($imageOriginalName, "."));//get image name without extension
        $imageName=$basename.date("YmdHis").'.'.$extension;//make new name
        $product_list_image = 'images/products/list/' . $imageName;
        $resizedImage = Intervention::make($image->getRealPath())->resize(84, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $cropped = $resizedImage->fit(84,84);
        $save = $cropped->save($product_list_image);

        $image = $request->img[0];
        $extension =$image->getClientOriginalExtension();//get image extension only
        $imageOriginalName= $image->getClientOriginalName();
        $basename = substr($imageOriginalName, 0 , strrpos($imageOriginalName, "."));//get image name without extension
        $imageName=$basename.date("YmdHis").'.'.$extension;//make new name
        $related_product_image = 'images/products/related/' . $imageName;
        $resizedImage = Intervention::make($image->getRealPath())->resize(50, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $cropped = $resizedImage->fit(50,50);
        $save = $cropped->save($related_product_image);

        $extension =$image->getClientOriginalExtension();//get image extension only
        $imageOriginalName= $image->getClientOriginalName();
        $basename = substr($imageOriginalName, 0 , strrpos($imageOriginalName, "."));//get image name without extension
        $imageName=$basename.date("YmdHis").'.'.$extension;//make new name
        $product_meta_image = 'images/products/meta/' . $imageName;
        $resizedImage = Intervention::make($image->getRealPath())->resize(650, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $save = $resizedImage->save($product_meta_image);
        $imgPaths = array();
        foreach ($request->img as $image){
            $extension =$image->getClientOriginalExtension();//get image extension only
            $imageOriginalName= $image->getClientOriginalName();
            $basename = substr($imageOriginalName, 0 , strrpos($imageOriginalName, "."));//get image name without extension
            $imageName=$basename.date("YmdHis").'.'.$extension;//make new name
            $path = 'images/products/' . $imageName;
            $resizedImage = Intervention::make($image->getRealPath())->resize(640, 640);
            $save = $resizedImage->save($path);
            if ($save){
                $imgPaths[] = $path;
            }
        }
        $implodedPaths = implode(',',$imgPaths);

        $product = new Product();
        $product->product_name = $request->product_name;
        $product->product_images = $implodedPaths;
        $product->short_desc = $request->short_desc;
        $product->description = $request->desc;
        $product->product_list_image = $product_list_image;
        $product->related_product_image = $product_list_image;
        $product->product_meta_image = $product_meta_image;
        $product->yt_video_url = $request->yt_video_url;
        $product->store_name = $request->store;
        $product->store_url = $productUrl;
        $product->product_id = $productId;
        $product->price = $request->price;
        $product->coupon = $request->coupon;
        $product->category = $request->category;
        $product->tags = $request->tags;
        $product->user_id = $userId;
        $product->username = $user->username;
        $product->views = 0;
        $product->product_votes = 0;
        $product->product_review = 0;
        $product->save();

        $title = preg_replace('/\s+/', '-', $product->product_name);
        $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
        $title = $title . '-' . $product->id;
        Toastr::success('Your product uploaded successfully!', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect('product/' . $title);
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
        $views = Product::find($id);
        $views->views += 1;
        $views->update();
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)){
            $userId = Auth::user()->id;
            $folders = Folder::where('user_id','=',$userId)->get();
        }

        $post = Product::find($id);
        $postUser = User::find($post->user_id);
        $post->product_reviews = $post->product_reviews()->get();
        $post->product_replies = $post->product_replies()->get();
        $post->product_votes = $post->product_votes()->get();
        $post->saved_products = $post->saved_products()->get();
        $post->product_url = '/go/'.$post->store_name.$post->product_id;
        $post->product_images = explode(',',$post->product_images);
        $tags = $post->tags;
        $category = $post->category;
        $post->short_desc = strip_tags($post->short_desc);
        $relatedPost = Product::where('id','!=',$post->id)->where('category','=',$category)->where('tags','=',$tags)->take(3)->get();
        foreach ($relatedPost as $relPost){
            $relPost->product_votes = $relPost->product_votes();
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
                    $related = Product::with('product_votes')->where('id', '!=', $post->id)->where('category', '=', $category)->where('tags', 'LIKE', '%' . $tag . '%')->whereNotIn('id',$ids)->take($countPost)->get();
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
            $related = Product::with('product_votes')->where('id','!=',$post->id)->where('tags','=',$tags)->whereNotIn('id',$ids)->take($countPost)->get();
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
                    $related = Product::with('product_votes')->where('id', '!=', $post->id)->where('tags', 'LIKE', '%' . $tag . '%')->whereNotIn('id',$ids)->take($countPost)->get();
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
            $related = Product::with('product_votes')->where('id','!=',$post->id)->where('category','=',$category)->whereNotIn('id',$ids)->inRandomOrder()->take($countPost)->get();
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
            $related = Product::with('product_votes')->where('id','!=',$post->id)->whereNotIn('id',$ids)->inRandomOrder()->take($countPost)->get();
            if (count($relatedPost) == 0) {
                $relatedPost = $related;
            } else{
                $relatedPost = $relatedPost->merge($related);
            }
        }
        $totalComments = count($post->product_reviews)+count($post->product_replies);
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)) {
            return view('pages.product', compact('post','totalComments','relatedPost','folders','postUser'));
        }else{
            return view('pages.product', compact('post','totalComments','relatedPost','postUser'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($title)
    {
//        dd($title);
        $exploded = explode('-', $title);
        $id = array_values(array_slice($exploded, -1))[0];
        $product = Product::find($id);
        if(isset(Auth::user()->id) && !empty(Auth::user()->id)){
        if ($product->user_id ==Auth::user()->id ){
            $stores = ProductStore::all();
            $categories = ProductCategory::all();
            return view('pages.editProduct', compact('product','categories','stores'));
        }else{
            return redirect()->back();
        }
        }else{
            return redirect()->back();
        }
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
        $this->validate($request,[
            'product_name'=>'required',
            'img'=>'required',
            'short_desc'=>'required',
            'category'=>'required',
            'price'=>'required',
            'desc'=>'required'
        ]);
        $store = $request->store;
        $productId = $request->productId;
        $storeInfo = ProductStore::where('store_name',$store)->first();
        $productUrl = $storeInfo->store_prefix.$productId;
        $product = Product::find($id);
        if (!empty($request->img)){
        $image = $request->img[0];
        $extension =$image->getClientOriginalExtension();//get image extension only
        $imageOriginalName= $image->getClientOriginalName();
        $basename = substr($imageOriginalName, 0 , strrpos($imageOriginalName, "."));//get image name without extension
        $imageName=$basename.date("YmdHis").'.'.$extension;//make new name
        $product_list_image = 'images/products/list/' . $imageName;
        $resizedImage = Intervention::make($image->getRealPath())->resize(84, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $cropped = $resizedImage->fit(84,84);
        $save = $cropped->save($product_list_image);

        $image = $request->img[0];
        $extension =$image->getClientOriginalExtension();//get image extension only
        $imageOriginalName= $image->getClientOriginalName();
        $basename = substr($imageOriginalName, 0 , strrpos($imageOriginalName, "."));//get image name without extension
        $imageName=$basename.date("YmdHis").'.'.$extension;//make new name
        $related_product_image = 'images/products/related/' . $imageName;
        $resizedImage = Intervention::make($image->getRealPath())->resize(50, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $cropped = $resizedImage->fit(50,50);
        $save = $cropped->save($related_product_image);

        $extension =$image->getClientOriginalExtension();//get image extension only
        $imageOriginalName= $image->getClientOriginalName();
        $basename = substr($imageOriginalName, 0 , strrpos($imageOriginalName, "."));//get image name without extension
        $imageName=$basename.date("YmdHis").'.'.$extension;//make new name
        $product_meta_image = 'images/products/meta/' . $imageName;
        $resizedImage = Intervention::make($image->getRealPath())->resize(650, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $save = $resizedImage->save($product_meta_image);
        $imgPaths = array();
        foreach ($request->img as $image){
            $extension =$image->getClientOriginalExtension();//get image extension only
            $imageOriginalName= $image->getClientOriginalName();
            $basename = substr($imageOriginalName, 0 , strrpos($imageOriginalName, "."));//get image name without extension
            $imageName=$basename.date("YmdHis").'.'.$extension;//make new name
            $path = 'images/products/' . $imageName;
            $resizedImage = Intervention::make($image->getRealPath())->resize(640, 640);
            $save = $resizedImage->save($path);
            if ($save){
                $imgPaths[] = $path;
            }
        }
        $implodedPaths = implode(',',$imgPaths);
        $product_previous_images = explode(',',$product->product_images);
        File::delete($product_previous_images,$product->product_list_image,$product->product_meta_image);

            $product->product_name = $request->title;
            $product->product_images = $implodedPaths;
            $product->short_desc = $request->short_desc;
            $product->description = $request->desc;
            $product->product_list_image = $product_list_image;
            $product->related_product_image = $product_list_image;
            $product->product_meta_image = $product_meta_image;
            $product->yt_video_url = $request->yt_video_url;
            $product->store_name = $request->store;
            $product->store_url = $productUrl;
            $product->product_id = $productId;
            $product->price = $request->price;
            $product->coupon = $request->coupon;
            $product->category = $request->category;
            $product->tags = $request->tags;
            $product->update();
        } else{
            $product->product_name = $request->title;
            $product->short_desc = $request->short_desc;
            $product->description = $request->desc;
            $product->yt_video_url = $request->yt_video_url;
            $product->store_name = $request->store;
            $product->store_url = $productUrl;
            $product->product_id = $productId;
            $product->price = $request->price;
            $product->coupon = $request->coupon;
            $product->category = $request->category;
            $product->tags = $request->tags;
            $product->update();
        }

        $title = preg_replace('/\s+/', '-', $product->product_name);
        $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
        $title = $title . '-' . $product->id;
        Toastr::success('Your product updated successfully!', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect('product/' . $title);
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

    public function redirectProductOriginalUrl($productId)
    {
//        preg_match_all('!\d+!', $productId, $matches);
//        $productId = $matches[0][0];
//        $affiliatePrefix = ProductSetting::first();
        $stores = ProductStore::all();
        foreach ($stores as $store){
            $productId = str_replace($store->store_name, "", $productId);
        }
        $product = Product::where('product_id',$productId)->first();
//        $finalUrl = $affiliatePrefix->affiliate_prefix.$product->store_url;
//        return Redirect::to($finalUrl);
        return Redirect::to($product->store_url);
    }
}
