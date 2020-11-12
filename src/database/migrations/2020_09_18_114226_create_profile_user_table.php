<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('profile_opened_at'); //Pour la date de début d'utilisation du profil
            $table->dateTime('profile_closed_at')->nullable(); //Pour la date de fin d'utilisation du profil
            $table->boolean('profile_user_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_user');
    }
}
