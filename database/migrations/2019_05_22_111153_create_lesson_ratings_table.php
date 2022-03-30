<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_ratings', function (Blueprint $table) {
            $table->unsignedInteger('educator_id');
            $table->unsignedInteger('parent_id');
            $table->unsignedInteger('lesson_id');
            $table->decimal('score');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('educator_id')
                ->references('id')->on('users');

            $table->foreign('parent_id')
                ->references('id')->on('users');

            $table->foreign('lesson_id')
                ->references('id')->on('lessons');

            $table->primary(['educator_id', 'parent_id', 'lesson_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_ratings');
    }
}
