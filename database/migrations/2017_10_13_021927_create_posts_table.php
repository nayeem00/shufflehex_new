<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title' ,512)->nullable();
            $table->string('link')->nullable()->unique();
            $table->string('domain')->nullable();
            $table->string('featured_image' , 1024)->nullable();
            $table->string('story_list_image' , 1024)->nullable();
            $table->string('related_story_image' , 1024)->nullable();
            $table->string('shuffle_box_image' , 1024)->nullable();
            $table->string('category')->nullable();
            $table->longText('description')->nullable();
            $table->string('tags')->nullable();
            $table->string('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('username')->nullable();
            $table->bigInteger('views')->nullable();
            $table->bigInteger('post_votes')->nullable();
            $table->bigInteger('post_comments')->nullable();
            $table->integer('is_link')->nullable();
            $table->integer('is_image')->nullable();
            $table->integer('is_video')->nullable();
            $table->integer('is_article')->nullable();
            $table->integer('is_list')->nullable();
            $table->integer('is_poll')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
