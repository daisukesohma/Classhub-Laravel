<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsInFreeVideoCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('free_video_calls', function (Blueprint $table) {
            $table->time('meeting_start')->nullable()->after('call_time');
            $table->string('meeting_link')->nullable()->after('call_time');

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
            $table->dropColumn('meeting_start');
            $table->dropColumn('meeting_link');
        });
    }
}
