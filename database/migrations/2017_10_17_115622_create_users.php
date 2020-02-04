<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('auuid');
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->boolean('new_user')->default(true);
            $table->boolean('is_deactivated')->default(false);
            $table->boolean('is_locked_out')->default(false);
            $table->timestamp('last_login_date');
            $table->string("remember_token", 255);
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
        Schema::dropIfExists('users');
    }
}
