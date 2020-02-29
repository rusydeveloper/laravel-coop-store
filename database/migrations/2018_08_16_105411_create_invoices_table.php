<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('business_id')->nullable();
            $table->text('customer')->nullable();
            $table->string('status')->default('order');
            $table->string('payment')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->float('discount')->nullable();
            $table->text('description')->nullable();
            $table->string('unique_id');
            $table->string('booking_id');
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
        Schema::dropIfExists('invoices');
    }
}
