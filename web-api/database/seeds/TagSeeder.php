<?php

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Tag::create([
            'name' => 'C#',
        ]);

        App\Tag::create([
            'name' => 'C',
        ]);

        App\Tag::create([
            'name' => 'C++',
        ]);

        App\Tag::create([
            'name' => 'Laravel',
        ]);

        App\Tag::create([
            'name' => 'PHP',
        ]);

        App\Tag::create([
            'name' => 'Composer',
        ]);

        App\Tag::create([
            'name' => 'MySQL',
        ]);

        App\Tag::create([
            'name' => 'SQL Server',
        ]);

        App\Tag::create([
            'name' => 'JavaScript',
        ]);

        App\Tag::create([
            'name' => 'R',
        ]);

        App\Tag::create([
            'name' => 'Python',
        ]);

        App\Tag::create([
            'name' => 'GO',
        ]);

        App\Tag::create([
            'name' => 'NodeJS',
        ]);

        App\Tag::create([
            'name' => 'VueJS',
        ]);

        App\Tag::create([
            'name' => 'HTML',
        ]);

        App\Tag::create([
            'name' => 'CSS',
        ]);

        App\Tag::create([
            'name' => 'Git',
        ]);

        App\Tag::create([
            'name' => 'GitHub',
        ]);

        App\Tag::create([
            'name' => 'Windows',
        ]);

        App\Tag::create([
            'name' => 'Linux',
        ]);

        App\Tag::create([
            'name' => 'Debian',
        ]);

        App\Tag::create([
            'name' => 'Debian Server',
        ]);

        App\Tag::create([
            'name' => 'Ubuntu',
        ]);

        App\Tag::create([
            'name' => 'Linux Mint',
        ]);

        App\Tag::create([
            'name' => 'Ajuda',
        ]);

        App\Tag::create([
            'name' => 'Programação',
        ]);

        App\Tag::create([
            'name' => 'Mecatrónica',
        ]);

        App\Tag::create([
            'name' => 'Java'
        ]);

        App\Tag::create([
            'name' => 'Outros',
        ]);
    }
}
