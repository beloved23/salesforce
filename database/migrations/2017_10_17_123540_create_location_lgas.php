<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationLgas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("location_lgas",function( Blueprint $table){
            $table->integer("id",true);
            $table->string("name",255);
            $table->string("lga_code",255);
            $table->integer("area_id");
            $table->timestamps();
           $table->foreign("area_id")->references("id")->on("location_areas");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("location_lgas");        
    }
}
