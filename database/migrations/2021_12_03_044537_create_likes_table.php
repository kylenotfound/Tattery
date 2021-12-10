<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('likes', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('likers_user_id');
            $table->foreign('likers_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('tattoo_id');
            $table->foreign('tattoo_id')->references('id')->on('tattoos')->onDelete('cascade');
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
        //
    }
}
