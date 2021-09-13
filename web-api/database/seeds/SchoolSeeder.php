<?php

use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\School::create([
            'name' => 'ATEC Matosinhos',
        ]);

        App\School::create([
            'name' => 'ATEC Palmela',
        ]);

        App\School::create([
            'name' => 'ATEC Cascais',
        ]);

    }
}
