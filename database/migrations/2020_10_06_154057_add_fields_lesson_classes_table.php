<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsLessonClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lesson_classes', function (Blueprint $table) {
            $table->string('video_status')->after('end_time')->default('in_progress')->nullable();
            $table->integer('video_id')->after('end_time')->nullable();
            $table->string('video_name')->after('end_time')->nullable();
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
            $table->dropColumn('video_status');
            $table->dropColumn('video_id');
            $table->dropColumn('video_name');
        });
    }
}
