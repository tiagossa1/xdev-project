<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'birth_date' => $faker->dateTimeThisMonth(),
        'github_url' => $faker->imageUrl(),
        'linkedin_url' => $faker->imageUrl(),
        'facebook_url' => $faker->imageUrl(),
        'instagram_url' => $faker->imageUrl(),
        'user_type_id' => rand(1,4),
        'district_id' => rand(1,20),
        'school_class_id' => rand(1,25),
        'suspended' => $faker->boolean(50)
    ];
});
