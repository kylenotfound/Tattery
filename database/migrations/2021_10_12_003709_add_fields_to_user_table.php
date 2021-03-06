<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUserTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::table('users', function (Blueprint $table) {
            $table->string("display_name")->after("name");
            $table->string("external_id")->nullable()->after("id");
            $table->string("avatar")->after("password")->default("user.png");
            $table->string("bio")->after("avatar")->default("No bio found");
            $table->string("virgin_status")->after("bio")->default("Virgin")->nullable();
            $table->string("unique_storage_dir")->after("bio");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            //
        });
    }
}
