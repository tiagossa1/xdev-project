<?php

use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\District::create([
            'name' => 'Porto',
        ]);

        App\District::create([
            'name' => 'Cascais',
        ]);

        App\District::create([
            'name' => 'Lisboa',
        ]);

        App\District::create([
            'name' => 'S.Joao da Madeira',
        ]);
    }
}
