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
        factory('App\Post', 10)->create();

        for ($i=1; $i <= 10; $i++) {
            DB::table('post_tag')->insert(
                [
                    'post_id' => $i,
                    'tag_id' => rand(1, 28),
                ]
            );

            DB::table('post_tag')->insert(
                [
                    'post_id' => $i,
                    'tag_id' => rand(1, 28),
                ]
            );

            DB::table('post_tag')->insert(
                [
                    'post_id' => $i,
                    'tag_id' => rand(1, 28),
                ]
            );
        }
    }
}
