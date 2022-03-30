<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferenceApproveEducatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educators', function (Blueprint $table) {
            $table->boolean('references_approved')->default(false)->after('references');
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
            $table->dropColumn('references_approved');
        });
    }
}
