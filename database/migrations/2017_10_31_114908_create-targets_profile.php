<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTargetsProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('targets_profile', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('target_id');
            $table->integer('assigned_to_user_id');
            $table->string('assigned_to_auuid', 50);
            $table->string('decrement', 100)->default('0');
            $table->string('kit', 100)->default('0');
            $table->string('gross_ads', 100)->default('0');
            $table->boolean('completed')->default(false);
            $table->timestamps();
            $table->foreign('assigned_to_user_id')->references('id')->on('users');
            $table->foreign('target_id')->references('id')->on('targets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('targets_profile');
    }
}
