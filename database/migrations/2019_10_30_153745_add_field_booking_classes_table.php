<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldBookingClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_classes', function (Blueprint $table) {
            $table->boolean('reminder_sent')->default(false);
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
            $table->dropColumn('reminder_sent');
        });
    }
}
