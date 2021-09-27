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
            'user_id' => 1,
            'feedback_type_id'=> 2,
            'description'=>"botão x não funciona"
    ]);
    }
}
