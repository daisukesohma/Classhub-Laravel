<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_requests', function (Blueprint $table) {
            $table->unsignedInteger('booking_id');
            $table->unsignedInteger('lesson_class_id');
            $table->integer('amount')->default(0);
            $table->integer('transaction_id')->nullable();
            $table->string('request_reason')->nullable();
            $table->string('decline_reason')->nullable();
            $table->boolean('dispute')->default(false);
            $table->enum('status', ['pending', 'granted', 'declined'])->default('pending');
            $table->enum('action_by', ['system', 'admin', 'tutor', 'parent'])->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('refund_requests');
    }
}
