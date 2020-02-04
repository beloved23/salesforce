<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInboxDraft extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbox_draft', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('sender_auuid', 10);
            $table->integer('sender_id');
            $table->string('message', 191);
            $table->boolean('is_file')->default(false);
            $table->string('message_filename')->nullable();
            $table->boolean('is_starred')->default(false);
            $table->boolean('is_trashed')->default(false);
            $table->boolean('is_drafted')->default(false);
            $table->string('label')->nullable();
            $table->foreign('sender_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inbox_draft');
    }
}
