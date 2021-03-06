<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirebaseToInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('invoices', function($table) {
        $table->string('firebase_user_id')->nullable();
            $table->string('firebase_invoice_id')->nullable();
    });

       Schema::table('users', function($table) {
        $table->string('firebase_user_id')->nullable();
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
        $table->string('firebase_user_id')->nullable();
            $table->string('firebase_invoice_id')->nullable();
    });

        Schema::table('users', function($table) {
        $table->string('firebase_user_id')->nullable();
    });
    }
}
