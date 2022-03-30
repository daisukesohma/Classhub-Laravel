<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_views', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lesson_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('ip')->nullable();
            $table->timestamps();

            $table->foreign('lesson_id')->references('id')->on('lessons');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_views');
    }
}
