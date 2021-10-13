<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->text(30),
        'description' => $faker->text(30),
        'suspended' => $faker->boolean(50),
        'user_id' => $faker->numberBetween(1, 4),
        'post_type_id' => $faker->numberBetween(1, 2)
    ];
});
