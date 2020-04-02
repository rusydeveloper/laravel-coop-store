<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('business_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('package_id')->nullable();
            $table->string('status')->default('order');
            $table->integer('payment_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('customer_payment_choice')->nullable();
            $table->integer('quantity')->nullable();
            $table->bigInteger('price')->nullable();
            $table->text('description')->nullable();
            $table->string('info_1')->nullable();
            $table->string('info_2')->nullable();
            $table->string('info_3')->nullable();
            $table->string('info_4')->nullable();
            $table->string('info_5')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('booking_id')->nullable();
            $table->string('card_number_qr')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
