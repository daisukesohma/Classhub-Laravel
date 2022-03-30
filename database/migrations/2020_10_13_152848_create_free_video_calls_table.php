<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreeVideoCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free_video_calls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('educator_id');
            $table->unsignedInteger('parent_id');
            $table->dateTime('call_time');
            $table->boolean('complete')->default(false);
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('free_video_calls');
    }
}
