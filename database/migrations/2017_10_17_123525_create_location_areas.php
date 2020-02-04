<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("location_areas",function(Blueprint $table){
            $table->integer("id",true);
            $table->string("name",255);
            $table->string("area_code",255);
            $table->integer("state_id");
            $table->timestamps();
           $table->foreign("state_id")->references("id")->on("location_states");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("location_areas");        
    }
}
