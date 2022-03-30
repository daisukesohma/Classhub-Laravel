<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn('parent_name');
            $table->string('for')->after('educator_image');
            $table->string('name')->after('educator_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn('for');
            $table->dropColumn('name');
        });
    }
}
