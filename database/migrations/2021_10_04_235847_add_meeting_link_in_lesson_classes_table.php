<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMeetingLinkInLessonClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lesson_classes', function (Blueprint $table) {
            $table->string('meeting_link')->nullable()->after('end_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lesson_classes', function (Blueprint $table) {
            $table->dropColumn('meeting_link');
        });
    }
}
