<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SchoolSeeder::class);
        $this->call(SchoolClassSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(UserTypeSeeder::class);
    }
}
