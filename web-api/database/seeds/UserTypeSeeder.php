<?php

use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\UserType::create([
            'name' => 'xDev',
            'hexColorCode' => '#32b9f9'
        ]);

        App\UserType::create([
            'name' => 'xMod',
            'hexColorCode' => '#fba026'
        ]);

        App\UserType::create([
            'name' => 'xSheriff',
            'hexColorCode' => '#fcbc67'
        ]);

        App\UserType::create([
            'name' => 'xOwner',
            'hexColorCode' => '#873be6'
        ]);
    }
}
