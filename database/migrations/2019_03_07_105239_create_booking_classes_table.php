<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_classes', function (Blueprint $table) {
            $table->unsignedInteger('booking_id');
            $table->unsignedInteger('lesson_class_id');
            $table->enum('status', ['completed', 'cancelled']);
            $table->enum('action_by',['system', 'admin', 'tutor', 'parent'])->nullable();

            $table->foreign('booking_id')
                ->references('id')->on('bookings')
                ->onDelete('cascade');

            $table->foreign('lesson_class_id')
                ->references('id')->on('lesson_classes');

            $table->primary(['booking_id', 'lesson_class_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_classes');
    }
}


