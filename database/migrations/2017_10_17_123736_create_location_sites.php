<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationSites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("location_sites", function (Blueprint $table) {
            $table->integer("id", true);
            $table->string("site_id", 255);
            $table->string("address", 255);
            $table->string("town_name", 255);
            $table->string("site_code", 255);
            $table->boolean("is_active")->default(true);
            $table->integer("territory_id");
            $table->string("class_code", 255);
            $table->string("latitude", 255);
            $table->string("longitude", 255);
            $table->string('classification')->nullable();
            $table->string('category')->nullable();
            $table->string('type')->nullable();
            $table->string('category_code')->nullable();
            $table->string('hubcode')->nullable();
            $table->string('commercial_classification')->nullable();
            $table->string('bsc_code')->nullable();
            $table->string('bsc_name')->nullable();
            $table->string('bsc_rnc')->nullable();
            $table->string('bts_type')->nullable();
            $table->string('cell_code')->nullable();
            $table->string('cell_id')->nullable();
            $table->string('cgi')->nullable();
            $table->string('city')->nullable();
            $table->string('ci')->nullable();
            $table->string('city_code')->nullable();
            $table->string('comment')->nullable();
            $table->string('corresponding_network')->nullable();
            $table->string('coverage_area')->nullable();
            $table->string('lac')->nullable();
            $table->string('msc_name')->nullable();
            $table->string('msc_code')->nullable();
            $table->string('mss')->nullable();
            $table->string('network_code')->nullable();
            $table->string('new_mss_pool')->nullable();
            $table->string('om_classification')->nullable();
            $table->string('vendor')->nullable();
            $table->string('new_zone')->nullable();
            $table->string('new_region')->nullable();
            $table->string('operational_date')->nullable();
            $table->string('location_information')->nullable();
            $table->timestamps();
            $table->foreign('territory_id')->references('id')->on('location_territories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("location_sites");
    }
}
