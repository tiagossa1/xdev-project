<?php

use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Feedback::create([
            'user_id' => 4,
            'feedback_type_id'=> 2,
            'description'=>"botão x não funciona"
        ]);

        App\Feedback::create([
            'user_id' => 1,
            'feedback_type_id'=> 3,
            'description'=>"botão y não funciona"
        ]);

        App\Feedback::create([
            'user_id' => 3,
            'feedback_type_id'=> 1,
            'description'=>"botão s não funciona"
        ]);

        App\Feedback::create([
            'user_id' => 2,
            'feedback_type_id'=> 2,
            'description'=>"botão 5 não funciona"
        ]);

        App\Feedback::create([
            'user_id' => 3,
            'feedback_type_id'=> 2,
            'description'=>"botão 6 não funciona"
        ]);
    }
}
