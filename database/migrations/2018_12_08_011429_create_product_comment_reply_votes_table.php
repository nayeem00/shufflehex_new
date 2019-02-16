<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCommentReplyVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_comment_reply_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vote');
            $table->string('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('comment_id')->references('id')->on('product_comments')->onDelete('cascade');
            $table->string('reply_id')->references('id')->on('product_replies')->onDelete('cascade');
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
        Schema::dropIfExists('product_comment_reply_votes');
    }
}
