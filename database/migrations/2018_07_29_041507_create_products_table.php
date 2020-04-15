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
            $table->integer('user_id');
            $table->integer('business_id');
            $table->integer('category_id')->nullable();
            $table->string('barcode')->nullable();
            $table->string('name');
            $table->string('type')->nullable();
            $table->integer('category')->nullable();
            $table->integer('subcategory')->nullable();
            $table->string('tag')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('price');
            $table->bigInteger('buying_price')->nullable();
            $table->integer('stock')->default(0);
            $table->string('status')->default('available');
            $table->string('image')->default('default_product.png');
            $table->string('priority')->nullable();
            $table->string('promo')->nullable();
            $table->text('info_1')->nullable();
            $table->text('info_2')->nullable();
            $table->text('info_3')->nullable();
            $table->text('info_4')->nullable();
            $table->text('info_5')->nullable();
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
        Schema::dropIfExists('products');
    }
}
