<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsBoardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_boards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('educator_id');
            $table->unsignedInteger('parent_id');
            $table->integer('subject_id');
            $table->text('message')->nullable();
            $table->boolean('applied')->default(false);
            $table->string('detail');
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('educator_id')
                ->references('id')
                ->on('users')->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs_board');
    }
}
