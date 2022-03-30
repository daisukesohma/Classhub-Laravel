<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsEducatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educators', function (Blueprint $table) {
            $table->integer('base_price')->nullable()->after('references_approved');
            $table->text('availability')->nullable()->after('base_price');
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
            $table->dropColumn('base_price');
            $table->dropColumn('availability');
        });
    }
}
