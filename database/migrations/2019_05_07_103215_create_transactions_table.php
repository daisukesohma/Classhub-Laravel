<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('booking_id')->nullable();
            $table->string('txn_id');
            $table->integer('amount');
            $table->text('txn_details');
            $table->string('status');
            $table->string('comment')->nullable();
            $table->enum('type', ['charge', 'payout', 'transfer', 'refund']);
            $table->timestamps();

            $table->foreign('booking_id')
                ->references('id')->on('bookings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
