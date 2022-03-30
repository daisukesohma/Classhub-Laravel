<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('stripe_cust_id')->nullable();
            $table->string('stripe_acct_id')->nullable();
            $table->string('bank_account')->nullable();
            //$table->string('stripe_secret_key')->nullable();
            //$table->string('stripe_publishable_key')->nullable();
            $table->string('remember_token')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
