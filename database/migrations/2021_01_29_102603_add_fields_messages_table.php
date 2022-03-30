<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function(Blueprint $table){
            $table->text('path')->nullable();
            $table->boolean('file_deleted')->default(false)
                ->nullable()->after('request_subject_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function(Blueprint $table){
            $table->dropColumn('path');
            $table->dropColumn('file_deleted');
        });
    }
}
