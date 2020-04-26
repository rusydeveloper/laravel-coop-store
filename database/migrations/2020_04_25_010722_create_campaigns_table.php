<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('unique_id');
            $table->integer('user_id');
            $table->integer('business_id');
            $table->integer('product_id');
            $table->string('title')->nullable();
            $table->string('status');
            $table->integer('quantity_ordered')->default(0);
            $table->integer('amount_ordered')->default(0);
            $table->integer('product_initial_price');
            $table->integer('product_initial_price_promoted')->nullable();
            $table->integer('product_tiering_price_1');
            $table->integer('product_tiering_price_2')->nullable();
            $table->integer('product_tiering_price_3')->nullable();
            $table->integer('product_tiering_quota_1');
            $table->integer('product_tiering_quota_2')->nullable();
            $table->integer('product_tiering_quota_3')->nullable();
            $table->integer('product_tiering_max');
            $table->dateTimeTz('start_at', 0);
            $table->dateTimeTz('end_at', 0);
            $table->integer('priority')->nullable();
            $table->text('info')->nullable();
            $table->text('tnc')->nullable();
            $table->text('promo')->nullable();
            $table->string('tag_1')->nullable();
            $table->string('tag_2')->nullable();
            $table->string('tag_3')->nullable();
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
        Schema::dropIfExists('campaigns');
    }
}
