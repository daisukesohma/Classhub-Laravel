<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikedLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liked_lessons', function (Blueprint $table) {
            $table->unsignedInteger('lesson_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('lesson_id')->references('id')->on('lessons');
            $table->foreign('user_id')->references('id')->on('users');

            $table->primary(['lesson_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('liked_lessons');
    }
}
