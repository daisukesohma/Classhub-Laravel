<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThumbnailPathImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->string('thumbnail_path')->nullable()->after('path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('thumbnail_path');
        });
    }
}
