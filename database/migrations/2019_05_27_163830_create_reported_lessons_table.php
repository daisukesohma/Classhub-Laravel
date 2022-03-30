<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportedLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reported_lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lesson_id');
            $table->unsignedInteger('reported_by');
            $table->text('reason');
            $table->timestamps();

            $table->foreign('lesson_id')
                ->references('id')->on('lessons');

            $table->foreign('reported_by')
                ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reported_lessons');
    }
}
