<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgencyHasLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_has_locations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('agency_id');
            $table->integer('location_id');
            $table->string('model_type');
            $table->timestamps();
            $table->foreign('agency_id')->references('id')->on('md_agencies')->onDelete('cascade');
            ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agency_has_locations');
    }
}
