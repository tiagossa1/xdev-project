<?php

use Illuminate\Database\Seeder;

class ForbiddenWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\ForbiddenWord::create([
            'name' => 'puta',
        ]);

        App\ForbiddenWord::create([
            'name' => 'pica',
        ]);

        App\ForbiddenWord::create([
            'name' => 'pissa',
        ]);

        App\ForbiddenWord::create([
            'name' => 'pixa',
        ]);

        App\ForbiddenWord::create([
            'name' => 'piroca',
        ]);

        App\ForbiddenWord::create([
            'name' => 'cona',
        ]);

        App\ForbiddenWord::create([
            'name' => 'cabrao',
        ]);

        App\ForbiddenWord::create([
            'name' => 'merda',
        ]);

        App\ForbiddenWord::create([
            'name' => 'nigger',
        ]);

        App\ForbiddenWord::create([
            'name' => 'nigga',
        ]);

        App\ForbiddenWord::create([
            'name' => 'fuck',
        ]);

        App\ForbiddenWord::create([
            'name' => 'dick',
        ]);

        App\ForbiddenWord::create([
            'name' => 'pussy',
        ]);

        App\ForbiddenWord::create([
            'name' => 'teste',
        ]);

        App\ForbiddenWord::create([
            'name' => 'fodasse',
        ]);

        App\ForbiddenWord::create([
            'name' => 'foda-se',
        ]);
    }
}
