<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationRegions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("location_regions",function(Blueprint $table){
            $table->integer("id",true);
            $table->string("name",255);
            $table->string("region_code",255);
            $table->integer("country_id");
            $table->timestamps();
            $table->foreign("country_id")->references("id")->on("location_country");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("location_regions");        
    }
}
