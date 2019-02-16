<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poll_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title' ,512)->nullable();
            $table->string('featured_image' , 1024)->nullable();
            $table->longText('description')->nullable();
            $table->string('post_id')->nullable()->references('id')->on('posts')->onDelete('cascade');
            $table->string('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('username')->nullable();
            $table->bigInteger('item_votes')->nullable();
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
        Schema::dropIfExists('poll_items');
    }
}
