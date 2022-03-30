<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10);
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('lesson_id')->nullable();
            $table->integer('amount');
            $table->integer('application_fee')->default(0);
            $table->integer('service_fee')->default(0);
            $table->integer('stripe_fee')->default(0);
            $table->boolean('stripe_fee_transferred')->default(0);
            $table->integer('refunded_amount')->default(0);
            $table->enum('status', ['completed', 'cancelled']);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('lesson_id')
                ->references('id')
                ->on('lessons')
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
        Schema::dropIfExists('bookings');
    }
}
