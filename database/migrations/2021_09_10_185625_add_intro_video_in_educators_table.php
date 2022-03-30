<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIntroVideoInEducatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educators', function (Blueprint $table) {
            $table->integer('intro_video')->nullable()->after('photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('educators', function (Blueprint $table) {
            $table->dropColumn('intro_video');
        });
    }
}
