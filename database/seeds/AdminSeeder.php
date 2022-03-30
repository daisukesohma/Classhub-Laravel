<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::firstOrCreate(['email' => 'admin@classhub.ie'], [
            'name' => 'Administrator',
            'email' => 'admin@classhub.ie',
            'slug' => 'administrator',
            'password' => Hash::make('secret'),
            'is_admin' => 1
        ]);

        /*$anonymous = \App\User::firstOrCreate(['email' => 'anonymous@classhub.ie'], [
            'name' => 'Anonymous',
            'email' => 'anonymous@classhub.ie',
            'slug' => 'anonymous',
            'password' => Hash::make('secret'),
            'is_admin' => 0
        ]);

        \App\Educator::create(['user_id' => $anonymous->id])*/;
    }
}
