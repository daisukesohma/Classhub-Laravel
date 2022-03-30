<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(AreasSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(GallerySeeder::class);
    }
}
