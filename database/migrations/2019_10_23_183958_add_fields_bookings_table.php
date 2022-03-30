<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('provider_fee_percent')->after('application_fee')->default(\App\Setting::get('provider_fee'));
            $table->decimal('customer_fee_percent')->after('service_fee')->default(\App\Setting::get('customer_fee'));
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('provider_fee_percent');
            $table->dropColumn('customer_fee_percent');
        });
    }
}
