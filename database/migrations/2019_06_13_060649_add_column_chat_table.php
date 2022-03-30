<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->unsignedInteger('lesson_id')->after('id')->nullable();

            $table->foreign('lesson_id')
                ->references('id')->on('lessons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn('lesson_id');
        });
    }
}
