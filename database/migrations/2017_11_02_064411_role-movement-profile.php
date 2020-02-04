<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleMovementProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_movement_profile', function (Blueprint $table) {
            $table->integer('id',true);
            $table->integer('role_movement_id');
            $table->string('requester_comment',255)->nullable();
            $table->string('attester_comment',255)->nullable();
            $table->string('denial_comment',255)->nullable();  
            $table->string('approval_comment',255)->nullable();                        
            $table->integer('no_of_kits')->default(0);
            $table->boolean('is_attestation_required')->default(false);            
            $table->boolean('is_attested')->default(false);
            $table->timestamps();
            $table->foreign('role_movement_id')->references('id')->on('role_movement');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_movement_profile');                
    }
}
