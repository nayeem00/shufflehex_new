<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('username')->nullable()->unique();
            $table->string('facebook')->nullable()->unique();
            $table->string('google_plus')->nullable()->unique();
            $table->string('linked_in')->nullable()->unique();
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
        Schema::dropIfExists('social_infos');
    }
}
