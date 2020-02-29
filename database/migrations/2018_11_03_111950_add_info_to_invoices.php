<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInfoToInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function($table) {
        $table->string('card_number')->nullable();
        $table->string('bank')->nullable();
        $table->integer('cash_amount')->nullable();
        $table->string('cashier_name')->nullable();
        $table->string('info')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function($table) {
        $table->dropColumn('card_number');
        $table->dropColumn('bank');
        $table->dropColumn('cash_amount');
        $table->dropColumn('cashier_name');
        $table->dropColumn('info');
    });
    }
}
