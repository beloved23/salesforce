<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInbox extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbox', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('sender_auuid')->nullable();
            $table->string('recipient_auuid')->nullable();
            $table->integer('sender_id');
            $table->integer('recipient_id');
            $table->longText('message');
            $table->string('subject', 50);
            $table->boolean('is_file')->default(false);
            $table->string('message_filename')->nullable();
            $table->boolean('is_read')->default(false);
            $table->boolean('is_starred')->default(false);
            $table->boolean('is_trashed')->default(false);
            $table->boolean('is_drafted')->default(false);
            $table->string('label')->nullable();
            $table->timestamps();
            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('recipient_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inbox');
    }
}
