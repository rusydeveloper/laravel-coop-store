<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBulksUnitsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('variation')->nullable()->after('unique_id');
            $table->string('retail_unit')->nullable()->after('unique_id');
            $table->string('bulk_unit')->nullable()->after('unique_id');
            $table->integer('bulk_to_retail')->nullable()->after('unique_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('variation');
            $table->dropColumn('retail_unit');
            $table->dropColumn('bulk_unit');
            $table->dropColumn('bulk_to_retail');
        });
    }
}
