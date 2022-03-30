<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->string('card_id');
            $table->string('last4');
            $table->string('brand');
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users');

            $table->primary(['user_id', 'card_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
