<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFolderStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folder_stories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title' ,512);
            $table->string('link')->unique();
            $table->string('domain');
            $table->string('featured_image' , 1024);
            $table->longText('description');
            $table->string('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('username');
            $table->string('folder_id')->references('id')->on('folders')->onDelete('cascade');
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
        Schema::dropIfExists('folder_stories');
    }
}
