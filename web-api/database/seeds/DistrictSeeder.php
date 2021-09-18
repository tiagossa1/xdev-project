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
            'name' => 'Aveiro',
        ]);

        App\District::create([
            'name' => 'Beja',
        ]);

        App\District::create([
            'name' => 'Braga',
        ]);

        App\District::create([
            'name' => 'Bragança',
        ]);

        App\District::create([
            'name' => 'Castelo Branco',
        ]);

        App\District::create([
            'name' => 'Coimbra',
        ]);

        App\District::create([
            'name' => 'Évora',
        ]);

        App\District::create([
            'name' => 'Faro',
        ]);

        App\District::create([
            'name' => 'Guarda',
        ]);

        App\District::create([
            'name' => 'Leiria',
        ]);

        App\District::create([
            'name' => 'Lisboa',
        ]);

        App\District::create([
            'name' => 'Portalegre',
        ]);

        App\District::create([
            'name' => 'Porto',
        ]);

        App\District::create([
            'name' => 'Região Autónoma da Madeira',
        ]);

        App\District::create([
            'name' => 'Região Autónoma dos Açores',
        ]);

        App\District::create([
            'name' => 'Santarém',
        ]);

        App\District::create([
            'name' => 'Setúbal',
        ]);

        App\District::create([
            'name' => 'Viana do Castelo',
        ]);

        App\District::create([
            'name' => 'Vila Real',
        ]);

        App\District::create([
            'name' => 'Viseu',
        ]);
    }
}
