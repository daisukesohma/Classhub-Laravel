<?php

use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Helpers\ClassHubHelper::custom_copy('public/galleries', 'storage/app/public/uploads/galleries');

        foreach (Storage::files('public/uploads/galleries') as $file){
            $fileNames = explode('/', $file);
            $name = $fileNames[count($fileNames)-1];
            $path = str_replace('public/', '', $file);

            \App\Image::create([
                'title' => $name,
                'path' => $path
            ]);
        }
    }
}
