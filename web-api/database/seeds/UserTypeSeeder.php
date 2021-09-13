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
            'hexColorCode' => 'Blue'
        ]);

        App\UserType::create([
            'name' => 'xMod',
            'hexColorCode' => 'Red'
        ]);

        App\UserType::create([
            'name' => 'xSheriff',
            'hexColorCode' => 'Orange'
        ]);

        App\UserType::create([
            'name' => 'xOwner',
            'hexColorCode' => 'Purple'
        ]);
    }
}
