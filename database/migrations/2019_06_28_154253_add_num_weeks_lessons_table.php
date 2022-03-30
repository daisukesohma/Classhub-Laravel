<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNumWeeksLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function(Blueprint $table){
            $table->integer('num_weeks')->default(0)
                ->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function(Blueprint $table){
            $table->dropColumn('num_weeks');
        });
    }
}
