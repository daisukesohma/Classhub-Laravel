<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lesson_id');
            $table->date('date')->nullable();
            $table->enum('day', ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']);
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('num_bookings')->default(0);
            $table->boolean('bookable')->default(true);
            $table->enum('status', [ 'live',  'paused', 'cancelled','completed'])
                ->default('live');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('lesson_id')
                ->references('id')->on('lessons')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_classes');
    }
}
