<?php

use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Report::create([
            'user_id' => 2,
            'post_id' => 1,
            'reason' => "Linguagem Ofensiva"
        ]);

        App\Report::create([
            'user_id' => 3,
            'post_id' => 1,
            'reason' => "Linguagem Ofensiva"
        ]);

        App\Report::create([
            'user_id' => 4,
            'post_id' => 2,
            'reason' => "Linguagem Ofensiva"
        ]);

    }
}
