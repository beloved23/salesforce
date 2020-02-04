<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInboxAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbox_attachments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('message_id');
            $table->integer('inbox_reply_id')->nullable();
            $table->string('attachment_filename');
            $table->timestamps();
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
        Schema::dropIfExists('inbox_attachments');
    }
}
