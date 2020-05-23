<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unique_id');
            $table->integer('business_id');
            $table->integer('user_id');
            $table->integer('inventory_id');
            $table->string('type');
            $table->string('status');
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('amount');
            $table->date('recorded_date');
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
        Schema::dropIfExists('inventory_histories');
    }
}
