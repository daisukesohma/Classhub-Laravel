<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('category_id')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->enum('type', ['single', 'group', 'term', 'subject', 'pre_recorded'])->default('single');
            $table->integer('price')->nullable();
            $table->enum('repeat_type', ['weekly'])->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('location')->nullable();
            $table->integer('age_from')->nullable();
            $table->string('age_to')->nullable();
            $table->text('description')->nullable();
            $table->integer('max_num_bookings')->nullable();
            $table->integer('num_bookings')->default(0);
            $table->boolean('bookable')->default(true);
            $table->enum('status', ['draft', 'live', 'paused', 'cancelled', 'expired', 'in_progress']) // in_progress = Video uploading
                ->default('live');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
