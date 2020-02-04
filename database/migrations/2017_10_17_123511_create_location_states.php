<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationStates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("location_states",function(Blueprint $table){
            $table->integer("id",true);
            $table->string("name",255);
            $table->string("state_code",255);
            $table->integer("zone_id");
            $table->timestamps();            
           $table->foreign("zone_id")->references("id")->on("location_zones");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("location_states");        
    }
}
