<?php

use Illuminate\Database\Seeder;

class PostPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\PostPhoto::create([
            'url' => 'www.google.pt',
            'post_id' => 2,
        ]);

        App\PostPhoto::create([
            'url' => 'www.google.pt',
            'post_id' => 1,
        ]);

        App\PostPhoto::create([
            'url' => 'www.google.pt',
            'post_id' => 4,
        ]);

        App\PostPhoto::create([
            'url' => 'www.google.pt',
            'post_id' => 5,
        ]);

        App\PostPhoto::create([
            'url' => 'www.google.pt',
            'post_id' => 3,
        ]);
    }
}
