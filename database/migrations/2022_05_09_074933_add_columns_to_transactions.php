<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('buyer_id');
            $table->dropColumn('seller_id');
            $table->dropColumn('bid_id');
            $table->dropColumn('coin_type');
            $table->dropColumn('coin_id');
            $table->string('from_address')->nullable();
            $table->string('to_address')->nullable();
            $table->string('token_address')->nullable();
            $table->string('token_id')->nullable();
            $table->string('type')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
        });
    }
}
