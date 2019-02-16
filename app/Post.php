<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
	protected $fillable = [
		'title', 'link', 'featured_image', 'story_list_image', 'related_story_image', 'shuffle_box_image', 'category', 'description', 'user_id', 'tags',
	];
	protected $dates = ['deleted_at'];

	public function votes() {
		return $this->hasMany('App\Vote');
	}

    public function comment_votes() {
        return $this->hasMany('App\CommentVote');
    }

    public function comment_reply_votes() {
        return $this->hasMany('App\CommentReplyVote');
    }

	public function comments() {
		return $this->hasMany('App\Comment');
	}
	public function replies() {
		return $this->hasMany('App\Reply');
	}

	public function users() {
		return $this->belongsTo('App\User');
	}

	public function saved_stories() {
		return $this->hasMany('App\SavedStories');
	}
	public function poll_items() {
		return $this->hasMany('App\PollItem');
	}

	public function folders() {
		return $this->belongsTo('App\Folder');
	}

//    public function poll_votes()
	//    {
	//        return $this->hasManyThrough('App\PollVote', 'App\PollItem','post-id','poll_item_id');
	//    }
}
