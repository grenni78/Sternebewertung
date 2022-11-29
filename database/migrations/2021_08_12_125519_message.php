<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Message extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->text('content');

            $table->integer('sender_id')->unsigned();
            $table->integer('recipient_id')->unsigned();

            $table->integer('reply_to')->unsigned()->nullable();

            $table->boolean('unread')->default(true);
            $table->boolean('pinned')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message');
    }
}
