<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducatorBacklogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educator_backlogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('educator_id');
            $table->unsignedInteger('category_id')->nullable();
            $table->timestamps();

            $table->foreign('educator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('educator_backlogs');
    }
}
