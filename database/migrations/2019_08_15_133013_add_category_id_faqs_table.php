<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryIdFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->unsignedInteger('category_id')->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('category_id');
            $table->string('category')->after('type');
        });
    }
}
