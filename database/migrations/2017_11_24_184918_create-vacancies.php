<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacancies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('location_model', 50);
            $table->integer('location_id');
            $table->string('location_name');
            $table->string('location_code');
            $table->string('required_profile');
            $table->boolean('pending_recruit')->default(false);
            $table->boolean('is_recruited')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacancies');
    }
}
