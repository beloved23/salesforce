<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationTerritories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("location_territories",function(Blueprint $table){
            $table->integer("id",true);
            $table->string("name",255);
            $table->string("territory_code",255);
            $table->integer("lga_id");
            $table->timestamps();
           $table->foreign("lga_id")->references("id")->on("location_lgas");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("location_territories");        
    }
}
