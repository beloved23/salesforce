<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("activity_logs", function (Blueprint $table) {
            $table->integer("user_id", true);
            $table->string("content_type_id", 255);
            $table->string("object_id", 255);
            $table->string("object_repr", 255);
            $table->datetime("action_time");
            $table->smallInteger("action_flag");
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("activity_logs");
    }
}
