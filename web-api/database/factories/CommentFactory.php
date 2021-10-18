<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'description' => $faker->text(30),
        'user_id' => $faker->numberBetween(1,4),
        'post_id' => $faker->numberBetween(1,4),
    ];
});
