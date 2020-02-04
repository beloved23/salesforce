<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationMovement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_movement', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('requester_auuid', 50);
            $table->integer('requester_id');
            $table->integer('initiated_by');
            $table->string('location_model', 50);
            $table->integer('location_id');
            $table->string('attester_auuid', 50)->nullable();
            $table->integer('attester_id')->nullable();
            $table->string('hr_auuid', 50)->nullable();
            $table->integer('hr_id')->nullable();
            $table->boolean('is_claimed')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_denied')->default(false);
            $table->boolean('is_cancelled')->default(false);
            $table->integer('requester_location_id');
            $table->foreign('requester_id')->references('id')->on('users');
            $table->foreign('attester_id')->references('id')->on('users');
            $table->foreign('hr_id')->references('id')->on('users');
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
        Schema::dropIfExists('location_movement');
    }
}
