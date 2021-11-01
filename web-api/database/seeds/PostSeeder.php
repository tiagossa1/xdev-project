<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        factory('App\Post', 10)->create();

        for ($i=1; $i <= 10; $i++) {
            DB::table('post_tag')->insert(
                [
                    'post_id' => $i,
                    'tag_id' => $faker->unique(true)->numberBetween(1, 3),
                ]
            );

            DB::table('post_tag')->insert(
                [
                    'post_id' => $i,
                    'tag_id' => $faker->unique(true)->numberBetween(4, 6),
                ]
            );

            DB::table('post_tag')->insert(
                [
                    'post_id' => $i,
                    'tag_id' => $faker->unique(true)->numberBetween(7, 9),
                ]
            );
        }
    }
}
