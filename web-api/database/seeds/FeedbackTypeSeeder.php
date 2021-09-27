<?php

use Illuminate\Database\Seeder;

class FeedbackTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\FeedbackType::create([
            'name' => 'Sugestão',
        ]);

        App\FeedbackType::create([
            'name' => 'Falha Técnica',
        ]);

        App\FeedbackType::create([
            'name' => 'Outros',
        ]);
    }
}
