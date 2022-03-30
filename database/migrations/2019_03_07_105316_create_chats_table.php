<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('initiator_id');
            $table->unsignedInteger('participant_id');
            $table->integer('initiator_unread_count')->default(0);
            $table->integer('participant_unread_count')->default(0);
            $table->text('last_message_text');
            $table->unsignedInteger('last_message_by');
            $table->timestamp('last_message_at');
            $table->timestamps();

            $table->foreign('initiator_id')
                ->references('id')
                ->on('users');

            $table->foreign('participant_id')
                ->references('id')
                ->on('users');

            $table->foreign('last_message_by')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chats');
    }
}
