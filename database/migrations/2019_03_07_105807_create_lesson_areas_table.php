<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_areas', function (Blueprint $table) {
            $table->unsignedInteger('lesson_id');
            $table->unsignedInteger('area_id');
            
            $table->foreign('lesson_id')
                ->references('id')->on('lessons')
                ->onDelete('cascade');
            
            $table->foreign('area_id')->references('id')->on('areas');
            
            $table->primary(['lesson_id', 'area_id']);
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_areas');
    }
}
