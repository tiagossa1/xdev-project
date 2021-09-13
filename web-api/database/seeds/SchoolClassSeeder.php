<?php

use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\SchoolClass::create([
            'name' => 'TPSI 10.20',
            'school_id' => '1'
        ]);

        App\SchoolClass::create([
            'name' => 'TPSI 10.21',
            'school_id' => '1'
        ]);
    }
}
