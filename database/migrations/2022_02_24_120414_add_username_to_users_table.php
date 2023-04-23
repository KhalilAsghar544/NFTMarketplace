<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsernameToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->after('email');
            $table->string('eth_address')->after('email');
            $table->decimal('eth_balance',19,8)->default(0)->after('email');
            $table->longText('signature')->after('email');
            //$table->string('email')->nullable()->unique(false)->change();
            $table->dropUnique('users_email_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('eth_address');
            $table->dropColumn('signature');
            $table->dropColumn('eth_balance');
        });
    }
}
