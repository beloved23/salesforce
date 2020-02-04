<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleshierachyProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("saleshierachy_profile",function(Blueprint $table){
            $table->string("user_auuid",10);
            $table->primary("user_auuid");
            $table->string('rod_auuid',255);
            $table->string('zbm_auuid',255);
            $table->string('asm_auuid',255);   
            $table->integer("region_id")->default(0);
            $table->integer("zone_id")->default(0);
            $table->integer("area_id")->default(0);
            $table->integer("state_id")->default(0);
            $table->integer("territory_id")->default(0);
            $table->timestamps();
            $table->foreign("region_id")->references("id")->on("location_regions");
            $table->foreign("zone_id")->references("id")->on("location_zones");
            $table->foreign("area_id")->references("id")->on("location_areas");
            $table->foreign("state_id")->references("id")->on("location_states");
            $table->foreign("territory_id")->references("id")->on("location_territories");            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("saleshierachy_profile");        
    }
}
