<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikedEducatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liked_educators', function (Blueprint $table) {
            $table->unsignedInteger('educator_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('educator_id')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');

            $table->primary(['educator_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('liked_educators');
    }
}
