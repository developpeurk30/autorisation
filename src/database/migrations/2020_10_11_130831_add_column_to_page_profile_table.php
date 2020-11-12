<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPageProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_profile', function (Blueprint $table) {
            $table->dateTime('page_allocate_to_profile_at'); //Pour la date de début d'utilisation de la page/permission
            $table->dateTime('page_retire_from_profile_at')->nullable(); //Pour la date de fin d'utilisation de la page/permission
            $table->boolean('profile_page_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page_profile', function (Blueprint $table) {
            $table->dropColumn('page_allocate_to_profile_at');
            $table->dropColumn('page_retire_from_profile_at');
            $table->dropColumn('profile_page_status');
        });
    }
}
