<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->string('type')->nullable()->default('message')->after('recipient_id');
            $table->integer('lesson_id')->nullable()->after('booking_id');
            $table->tinyInteger('booking_response')->nullable();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('lesson_id');
            $table->dropColumn('booking_response');
        });
    }
}
