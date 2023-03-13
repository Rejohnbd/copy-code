<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->string('user_type')->default('client')->after('password');
            $table->string('avatar')->default('avatar.png')->after('user_type');
            $table->tinyInteger('user_status')->default(1)->after('avatar')->comment('0 = inactive user, 1 = active user, 2 = suspended user');
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
            $table->string('name');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('user_type');
            $table->dropColumn('avatar');
            $table->dropColumn('user_status');
        });
    }
};
