<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->boolean('travel_to_tutor')->default(false)->after('description');
            $table->boolean('travel_to_student')->default(false)->after('travel_to_tutor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('travel_to_tutor');
            $table->dropColumn('travel_to_student');
        });
    }
}
