<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_histories', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id', false);
            $table->string('type');
            $table->integer('from_id')->nullable();
            $table->string('from_model')->nullable();
            $table->date('from_date')->nullable();
            $table->string('to_date');
            $table->integer('destination_id');
            $table->string('destination_model');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_histories');
    }
}
