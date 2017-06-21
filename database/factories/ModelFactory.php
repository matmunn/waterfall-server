<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Entry::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->sentence(4),
        'start_date' => $faker->dateTimeBetween('now', '+3 hours'),
        'end_date' => $faker->dateTimeBetween('+3 hours', '+6 hours'),
        'completed' => $faker->boolean(),
    ];
});
