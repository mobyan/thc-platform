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
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\DeviceData::class, function (Faker\Generator $faker) {

    $data = [
        'ts' => $faker->dateTimeThisMonth,
        'data' => ['t_30' => [ 'value' => $faker->numberBetween(1, 100)]],
        'device_config_id' => $faker->numberBetween(1, 100),
        'device_id' => $faker->numberBetween(1, 100),
    ];
    $data['data'] = json_encode($data['data']);
    return $data;
});

$factory->define(App\DeviceConfig::class, function (Faker\Generator $faker) {

    $data = [
        'data' => ['t_30' => [ 'unit' => $faker->numberBetween(1, 100)]],
        'control' => ['t_30' => [ 'value' => $faker->numberBetween(1, 100)]],
        'device_id' => $faker->numberBetween(1, 100),
    ];
    $data['data'] = json_encode($data['data']);
    $data['control'] = json_encode($data['control']);
    return $data;
});

$factory->define(App\Device::class, function (Faker\Generator $faker) {

    return [
        'station_id' => $faker->numberBetween(1, 100),
    ];
});

$factory->define(App\Station::class, function (Faker\Generator $faker) {

    return [
        'app_id' => $faker->numberBetween(1, 100),
    ];
});

$factory->define(App\App::class, function (Faker\Generator $faker) {

    return [
    ];
});

