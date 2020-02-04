<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("users_profile", function (Blueprint $table) {
            $table->integer("user_id", true);
            $table->string('first_name', 250)->nullable();
            $table->string('last_name', 250)->nullable();
            $table->string("profile_picture", 255);
            $table->string("auuid", 255);
            $table->string("phone_number", 255)->nullable();
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("users_profile");
    }
}
