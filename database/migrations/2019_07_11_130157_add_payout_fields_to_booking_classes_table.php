<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayoutFieldsToBookingClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_classes', function (Blueprint $table) {
            $table->integer('transaction_id')->nullable();
            $table->integer('payout_amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_classes', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
            $table->dropColumn('payout_amount');
        });
    }
}
