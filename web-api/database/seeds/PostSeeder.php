<?php

use Illuminate\Database\Seeder;

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
                    'tag_id' => 2,
                ]
            );

            DB::table('post_tag')->insert(
                [
                    'post_id' => $i,
                    'tag_id' => 3,
                ]
            );

            DB::table('post_tag')->insert(
                [
                    'post_id' => $i,
                    'tag_id' => 1,
                ]
            );
        }
    }
}
