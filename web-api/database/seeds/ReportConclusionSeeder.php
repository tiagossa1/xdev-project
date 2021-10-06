<?php

use App\ReportConclusion;
use Illuminate\Database\Seeder;

class ReportConclusionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReportConclusion::create([
            'name' => 'Suspenso'
        ]);

        ReportConclusion::create([
            'name' => 'Sem medidas tomadas'
        ]);

    }
}
