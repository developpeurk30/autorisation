<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProfileUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile_user', function (Blueprint $table) {
            //
            $table->foreign('profile_id','fk_profile_to_profile_user')->references('id')->on('profiles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('user_id','fk_user_to_profile_user')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile_user', function (Blueprint $table) {
            //
            $table->dropForeign('fk_profile_to_profile_user');
            $table->dropForeign('fk_user_to_profile_user');
        });
    }
}
