<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('business_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('package_id')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('status')->nullable();
            $table->string('title')->nullable();
            $table->string('category')->nullable();
            $table->string('caption')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('pictures');
    }
}
