<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('birth_date')->nullable(false);
            $table->string('phone')->nullable();
            $table->string('username')->unique();
            $table->string('photo')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('password_changed')->default(0);
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
            $table->dropColumn('birth_date');
            $table->dropColumn('phone');
            $table->dropColumn('username');
            $table->dropColumn('photo');
            $table->dropColumn('status');
            $table->dropColumn('password_changed');
        });
    }
}
