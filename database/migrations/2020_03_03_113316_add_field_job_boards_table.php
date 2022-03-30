<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldJobBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_boards', function (Blueprint $table) {
            $table->timestamp('notified_at')->nullable()->after('detail');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_boards', function (Blueprint $table) {
            $table->dropColumn('notified_at');
        });
    }
}
