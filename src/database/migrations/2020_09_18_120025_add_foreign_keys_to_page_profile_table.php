<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPageProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_profile', function (Blueprint $table) {
            //
            $table->foreign('page_id','fk_page_to_page_profile')->references('id')->on('pages')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('profile_id','fk_profile_to_page_profile')->references('id')->on('profiles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
            //
            $table->dropForeign('fk_page_to_page_profile');
            $table->dropForeign('fk_profile_to_page_profile');
        });
    }
}
