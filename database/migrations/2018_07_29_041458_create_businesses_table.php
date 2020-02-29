<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('status')->default('active');
            $table->text('description');
            $table->string('category');
            $table->string('subcategory')->nullable();
            $table->text('contact')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('village')->nullable();
            $table->string('district')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('picture')->default('default_business.jpg');
            $table->string('unique_id');
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
        Schema::dropIfExists('businesses');
    }
}
