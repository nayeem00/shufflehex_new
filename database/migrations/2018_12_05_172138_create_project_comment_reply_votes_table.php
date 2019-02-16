<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectCommentReplyVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_comment_reply_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vote');
            $table->string('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->string('comment_id')->references('id')->on('project_comments')->onDelete('cascade');
            $table->string('reply_id')->references('id')->on('project_replies')->onDelete('cascade');
            $table->string('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('project_comment_reply_votes');
    }
}
