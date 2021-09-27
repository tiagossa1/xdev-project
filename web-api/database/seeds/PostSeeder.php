<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Post::create([
            'title' => 'Como fazer um Array em c++',
            'description' => 'Boa Tarde, gostaria que me ajudassem a fazer um array em c++, Obrigado!',
            'user_id' => 1,
            'post_type_id' => 2,
        ]);

        App\Post::create([
            'title' => 'Como fazer uma matriz em c++',
            'description' => 'Boa Tarde, gostaria que me ajudassem a fazer uma matriz em c++, Obrigado!',
            'user_id' => 3,
            'post_type_id' => 2,
        ]);

        App\Post::create([
            'title' => 'Como fazer um Array de Arrays em c#',
            'description' => 'Boa Tarde, gostaria que me ajudassem a fazer um array de arrays em c#, Obrigado!',
            'user_id' => 1,
            'post_type_id' => 2,
        ]);

        App\Post::create([
            'title' => 'Trabalhar na Jolera',
            'description' => 'Jolera recruta colaboradores jovens e dinamicos para redes para o ano 2022',
            'user_id' => 8,
            'post_type_id' => 1,
        ]);

        App\Post::create([
            'title' => 'Trabalhar na Farfetch',
            'description' => 'Farfetch recruta colaboradores jovens e dinamicos para redes para o ano 2022',
            'user_id' => 8,
            'post_type_id' => 1,
        ]);
    }
}
