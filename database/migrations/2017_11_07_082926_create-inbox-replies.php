<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInboxReplies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbox_replies', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('sender_id');
            $table->integer('message_id');
            $table->integer('recipient_id');
            $table->longText('reply');
            $table->string('subject', 50)->nullable();
            $table->boolean('is_file')->default(false);
            $table->string('message_filename')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('recipient_id')->references('id')->on('users');
            $table->foreign('message_id')->references('id')->on('inbox');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inbox_replies');
    }
}
