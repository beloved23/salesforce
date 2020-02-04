<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationZones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("location_zones",function (Blueprint $table){
            $table->integer("id",true);
            $table->string("name",255);
            $table->string("zone_code",255);
            $table->integer("region_id",false);
            $table->timestamps();
            $table->foreign("region_id")->references("id")->on("location_regions");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("location_zones");        
    }
}
