<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_name' ,512)->nullable();
            $table->string('product_images',1024)->nullable();
            $table->longText('short_desc')->nullable();
            $table->longText('description')->nullable();
            $table->string('featured_image' , 1024)->nullable();
            $table->string('product_list_image' , 1024)->nullable();
            $table->string('related_product_image' , 1024)->nullable();
            $table->string('product_meta_image' , 1024)->nullable();
            $table->string('yt_video_url' , 1024)->nullable();
            $table->string('store_name')->nullable();
            $table->string('store_url' , 1024)->nullable();
            $table->string('product_id' , 255)->nullable();
            $table->string('price')->nullable();
            $table->string('coupon')->nullable();
            $table->string('category')->nullable();
            $table->string('tags')->nullable();
            $table->string('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('username')->nullable();
            $table->bigInteger('views')->nullable();
            $table->bigInteger('product_votes')->nullable();
            $table->double('product_review', 1, 1)->nullable();
            $table->bigInteger('total_reviews')->nullable();
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
        Schema::dropIfExists('products');
    }
}
