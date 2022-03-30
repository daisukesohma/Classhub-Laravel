<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldFreeCallTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('free_video_calls', function (Blueprint $table) {
            $table->boolean('reminder_sent')->default(false);
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('free_video_calls', function (Blueprint $table) {
            $table->dropColumn('reminder_sent');
        });
    }
}
