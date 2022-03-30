<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_images', function (Blueprint $table) {
            $table->unsignedInteger('lesson_id');
            $table->unsignedInteger('image_id');

            $table->foreign('lesson_id')->references('id')->on('lessons');
            $table->foreign('image_id')->references('id')->on('images');

            $table->primary(['lesson_id', 'image_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_images');
    }
}
