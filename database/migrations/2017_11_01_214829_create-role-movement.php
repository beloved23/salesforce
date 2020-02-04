<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleMovement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_movement', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('requester_auuid', 50);
            $table->string('resource_auuid', 50)->nullable();
            $table->string('attester_auuid', 50)->nullable();
            $table->integer('requester_id');
            $table->integer('resource_id');
            $table->integer('attester_id')->nullable();
            $table->string('hr_auuid', 50)->nullable();
            $table->boolean('is_claimed')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_denied')->default(false);
            $table->integer('resource_role_id');
            $table->integer('requested_role_id');
            $table->foreign('requester_id')->references('id')->on('users');
            $table->foreign('resource_id')->references('id')->on('users');
            $table->foreign('attester_id')->references('id')->on('users');
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
        Schema::dropIfExists('role_movement');
    }
}
