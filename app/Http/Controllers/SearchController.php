<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Product;
use App\Project;

class SearchController extends Controller
{
    public function limit_text($text, $limit)
    {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }

    public function search(Request $request)
    {
        $searchText = $request->search;
        $stories = Post::where('title', 'like', '%' . $request->search . '%')->get();
        $countStories = count($stories);
        if ($countStories<10){
            $restStories = 10-$countStories;
            $ids = array();
            foreach ($stories as $story){
                $ids[] = $story->id;
            }
//            dd($restStories);
            $storiesMatchedWithDescription = Post::where('description', 'like', '%' . $request->search . '%')->whereNotIn('id',$ids)->limit($restStories)->get();
//            dd($storiesMatchedWithDescription);
            $stories = $stories->merge($storiesMatchedWithDescription);
        }
        foreach ($stories as $story){
            $title = preg_replace('/\s+/', '-', $story->title);
            $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
            $title = $title . '-' . $story->id;
            $storyLink = 'story/'.$title;
            $story->story_link = $storyLink;
            $storyTitle = $this->limit_text($story->title, 12);
            $story->title = $storyTitle;

        }

        $products = Product::where('product_name', 'like', '%' . $request->search . '%')->get();
        $countProducts = count($products);
        if ($countProducts<5){
            $restProducts = 5-$countProducts;
            $ids = array();
            foreach ($products as $product){
                $ids[] = $product->id;
            }
//            dd($restStories);
            $productsMatchedWithDescription = Product::where('description', 'like', '%' . $request->search . '%')->whereNotIn('id',$ids)->limit($restProducts)->get();
//            dd($storiesMatchedWithDescription);
            $products = $products->merge($productsMatchedWithDescription);
        }
        foreach ($products as $product){
            $title = preg_replace('/\s+/', '-', $product->product_name);
            $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
            $title = $title . '-' . $product->id;
            $productLink = 'product/'.$title;
            $product->product_link = $productLink;
            $productName = $this->limit_text($product->product_name, 12);
            $product->product_name = $productName;
        }

        $projects = Project::where('title', 'like', '%' . $request->search . '%')->get();
        $countProjects = count($projects);
        if ($countProjects<5){
            $restProjects = 5-$countProjects;
            $ids = array();
            foreach ($projects as $project){
                $ids[] = $project->id;
            }
//            dd($restStories);
            $projectsMatchedWithDescription = Project::where('description', 'like', '%' . $request->search . '%')->whereNotIn('id',$ids)->limit($restProjects)->get();
//            dd($storiesMatchedWithDescription);
            $projects = $projects->merge($projectsMatchedWithDescription);
        }
        foreach ($projects as $project){
            $title = preg_replace('/\s+/', '-', $project->title);
            $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
            $title = $title . '-' . $project->id;
            $projectLink = 'project/'.$title;
            $project->project_link = $projectLink;
            $projectTitle = $this->limit_text($project->title, 12);
            $project->title = $projectTitle;
        }
        return view('pages/search', compact('stories', 'products','projects','searchText'));
    }
}
