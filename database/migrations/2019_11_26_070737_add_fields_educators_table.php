<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsEducatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educators', function (Blueprint $table) {
            $table->string('setup_class_reminder')->nullable()->after('references_approved');
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
            $table->dropColumn('setup_class_reminder');
        });
    }
}
