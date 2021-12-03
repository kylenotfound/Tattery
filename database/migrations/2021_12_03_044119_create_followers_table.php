<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('followers', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('follower_user_id');
            $table->foreign('follower_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('followee_user_id');
            $table->foreign('followee_user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('followers');
    }
}
