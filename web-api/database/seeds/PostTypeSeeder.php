<?php

use Illuminate\Database\Seeder;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\PostType::create([
            'name' => 'Oferta de Emprego',
            'iconName' => 'www.ofertadeemprego.org'
        ]);

        App\PostType::create([
            'name' => 'Post',
            'iconName' => 'www.Post.org'
        ]);
    }
}
