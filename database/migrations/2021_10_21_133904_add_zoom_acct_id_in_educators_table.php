<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddZoomAcctIdInEducatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educators', function (Blueprint $table) {
            $table->string('zoom_acct_id')->nullable()->after('setup_class_reminder');
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
            $table->dropColumn('zoom_acct_id');
        });
    }
}
