<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educators', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->enum('type', ['individual', 'company'])->default('individual');
            $table->date('dob')->default(date('Y-m-d'))->nullable();
            $table->text('qualifications')->nullable();
            $table->unsignedInteger('photo')->nullable();
            $table->text('bio')->nullable();
            $table->decimal('provider_fee', 10, 2)->nullable();
            $table->decimal('customer_fee', 10, 2)->nullable();
            $table->string('teaching_types');
            $table->string('references')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')->onDelete('cascade');
            
            $table->foreign('photo')
                ->references('id')
                ->on('images');
            
            $table->primary('user_id');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('educators');
    }
}
