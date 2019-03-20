<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

//Route::any('{query}',
//    function() { return redirect('/'); })
//    ->where('query', '.*');
//Route::get('/', [ 'as' => '/', 'uses' => function () {
//    return redirect('/story');
//}]);

//Route::get('/pages/add', function () {
//    return view('pages.add');
//});
Route::get('login/google', 'Auth\RegisterController@redirectToProvider');
Route::get('login/google/callback', 'Auth\RegisterController@handleProviderCallback');
Route::get('/feed', 'FeedController@feed');
Route::get('/story/latest', 'PostController@latestPost');
Route::get('/story/top/', 'PostController@topPost');
Route::get('/story/popular/', 'PostController@popularPost');
Route::get('/story/trending', 'PostController@trendingPost');
//Route::get('/story/web', 'PostController@webPost');
//Route::get('/story/images', 'PostController@imagesPost');
//Route::get('/story/videos', 'PostController@videosPost');
//Route::get('/story/articles', 'PostController@articlesPost');
//Route::get('/story/lists', 'PostController@listsPost');
//Route::get('/story/polls', 'PostController@pollsPost');
Route::post('/ajax/get_more_post', 'AjaxController@get_more_post');
Route::post('/ajax/get_filterd_post', 'AjaxController@get_filterd_post');
Route::get('/go/{productId}', 'ProductController@redirectProductOriginalUrl');
Route::get('/search', 'SearchController@search')->name('search.all');
Route::get('/pages/all', function () {
    return view('pages.all');
});
Route::get('/pages/blog', function () {
    return view('pages.blog');
});
Route::get('/pages/signin', function () {
    return view('auth.login');
});
Route::get('/pages/register', function () {
    return view('pages.register');
});
Route::get('/pages/about', function () {
    return view('pages.about');
});
Route::get('/pages/privacy', function () {
    return view('pages.privacy');
});
Route::get('/pages/support', function () {
    return view('pages.support');
});
Route::get('/verify/email', function () {
    return view('pages.emailVerify');
});

//Route::get('/addproduct', function () {
//	return view('pages.addProduct');
//});
//
//Route::get('/product', function () {
//	return view('pages.product');
//});
//
//Route::get('/allproduct', function () {
//	return view('pages.allProduct');
//});

//Route::get('/addproject', function () {
//	return view('pages.addProject');
//});
//
//Route::get('/allproject', function () {
//	return view('pages.allProject');
//});
//
//Route::get('/project', function () {
//	return view('pages.project');
//});

Route::get('/page404', function () {
    return view('pages.page404');
});

Route::get('/', 'PostController@index');
Route::get('/add', 'PostController@create');
Route::get('/story/{title}/edit', 'PostController@edit');
Route::get('/story/{title}', 'PostController@show');
Route::post('/story/save', 'PostController@store')->name('story.store');
Route::patch('/story/update', 'PostController@store')->name('story.update');

Route::get('/products', 'ProductController@index');

Route::get('/projects', 'ProjectController@index');
Route::get('/addproject', 'ProjectController@create');
Route::get('/project/{title}', 'ProjectController@show');
Route::get('/projects/newest', 'ProjectController@newestProjects');
Route::get('/projects/popular', 'ProjectController@popularProjects');

Route::get('/products', 'ProductController@index');
Route::get('/addproduct', 'ProductController@create');
Route::get('/product/{title}', 'ProductController@show');
Route::get('/products/newest', 'ProductController@newestProjects');
Route::get('/products/popular', 'ProductController@popularProjects');
Route::get('/product/{title}/edit', 'ProductController@edit');
Route::get('/project/{title}/edit', 'ProjectController@edit');
Route::patch('/product/{id}', 'ProductController@update')->name('product.update');
Route::patch('/project/{id}', 'ProjectController@update')->name('project.update');

//Route::get('/story/{title}', 'PostController@showPost');
Route::get('/view/{title}', 'PostController@viewPost');
Route::get('/profile/{username}', 'PostController@userWisePosts');
Route::get('/source/{domain}', 'PostController@domainWisePosts');
Route::resource('/category', 'CategoryController');
Auth::routes();

Route::get('/topics', 'TopicController@index');

//Route::get('/home', 'HomeController@index')->name('home');
//Route::post('/addPost', 'PostController@store')->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::resource('/user/profile', 'ProfileController');
    Route::get('/user/posts', 'ProfileController@userPosts');
    Route::get('/user/settings', 'ProfileController@settings');
    Route::get('/user/change_password', 'ProfileController@change_password');
    Route::post('/user/changePassword', [
        'uses' => 'ProfileController@changePassword',
        'as' => 'password-reset',
    ]);
    Route::post('/projectCommentSave', [
        'uses' => 'ProjectCommentController@store',
        'as' => 'project_comment.store',
    ]);
    Route::post('/projectReplySave', [
        'uses' => 'ProjectReplyController@store',
        'as' => 'project_reply.store',
    ]);
    Route::post('projectStore', [
        'uses' => 'ProjectController@store',
        'as' => 'project.store',
    ]);
    Route::post('productStore', [
        'uses' => 'ProductController@store',
        'as' => 'product.store',
    ]);
    Route::get('/user/social_info', 'ProfileController@social_info');
    Route::post('/user/socialInfo', [
        'uses' => 'ProfileController@socialInfo',
        'as' => 'socialInfo',
    ]);
    Route::post('/user/profilePictureUpload', [
        'uses' => 'ProfileController@profilePictureUpload',
        'as' => 'profilePictureUpload',
    ]);
    Route::post('/vote', 'VoteController@store');
    Route::post('/commentVote', 'CommentVoteController@store');
    Route::post('/projectCommentVote', 'CommentVoteController@projectCommentVote');
    Route::post('/commentReplyVote', 'CommentReplyVoteController@store');
    Route::post('/projectCommentReplyVote', 'CommentReplyVoteController@projectCommentReplyVote');
    Route::resource('/comment', 'CommentController');
    Route::resource('/reply', 'ReplyController');
    Route::resource('/image', 'ImageController');
    Route::resource('/video', 'VideoController');
    Route::resource('/article', 'ArticleController');
    Route::post('/vote/downVote', 'VoteController@downVote');
    Route::post('/project/upvote', 'VoteController@projectUpvote');
    Route::post('/product/upvote', 'VoteController@productUpvote');
    Route::post('/project/downvote', 'VoteController@projectDownvote');
    Route::post('/product/downvote', 'VoteController@productDownvote');
    Route::post('product_review', 'ProductReviewController@store')->name('review.store');
    Route::resource('/saveStory', 'savedStoriesController');
    Route::resource('/saveProject', 'savedProjectsController');
    Route::get('/saved', 'PostController@savedPost');
    Route::resource('/folder', 'FolderController');
    Route::get('updateFolder', 'FolderController@updateFolder');
    Route::get('deleteFolder', 'FolderController@deleteFolder');
    Route::get('/folders', 'FolderController@allFolders');
    Route::get('/user/notifications', 'PostController@notifications');
    Route::resource('/folderStory', 'FolderStoryController');
    Route::resource('/folderProject', 'FolderProjectController');
    Route::resource('/poll', 'PollController');
    Route::resource('/list', 'ListController');
    Route::resource('/poll_item', 'PollItemController');
    Route::post('/poll_vote', 'PollVoteController@store');
    Route::post('/poll_downvote', 'PollVoteController@downvote');
    Route::post('searchTopic', 'CategoryController@searchTopic');
    Route::post('createTopic', 'CategoryController@createTopic');
    Route::get('/markAsRead', function () {
        auth()->user()->unreadNotifications->markAsRead();
    });
    Route::post('generate', 'PostController@generateContentFromUrl');

});