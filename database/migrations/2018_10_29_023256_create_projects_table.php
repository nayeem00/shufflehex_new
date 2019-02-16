<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title' ,512)->nullable();
            $table->string('link')->nullable()->unique();
            $table->string('tag_line' ,1024)->nullable();
            $table->longText('description')->nullable();
            $table->string('logo' , 512)->nullable();
            $table->string('small_logo' , 512)->nullable();
            $table->string('screenshots' , 512)->nullable();
            $table->string('category')->nullable();
            $table->string('tags')->nullable();
            $table->string('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('username')->nullable();
            $table->bigInteger('views')->nullable();
            $table->bigInteger('project_votes')->nullable();
            $table->bigInteger('project_comments')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
