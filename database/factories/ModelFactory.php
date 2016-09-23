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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(123456),
        'remember_token' => str_random(10),
        'state' => $faker->state
    ];
});

$factory->define(App\Rate::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->state,
        'bg' => $faker->state,
        'sg' => $faker->state,
        'bb' => $faker->state,
        'sb' => $faker->state,
    ];
});

$factory->define(App\Relation::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->state,
        'up' => $faker->state,
    ];
});
