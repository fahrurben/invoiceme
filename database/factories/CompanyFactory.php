<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Domain\Company\Models\Company::class, function (Faker $faker, array $attributes) {
    $name =  isset($attributes['name']) ? $attributes['name'] : $faker->unique()->name();
    $address =  isset($attributes['address']) ? $attributes['addres'] : $faker->address();
    $city =  isset($attributes['city']) ? $attributes['city'] : $faker->city();
    $phone =  isset($attributes['phone']) ? $attributes['phone'] : $faker->phoneNumber();
    $email = isset($attributes['email']) ? $attributes['email'] : $faker->email();

    return [
        'name' => $name,
        'user' => $attributes['user'],
        'address' => $address,
        'city' => $city,
        'phone' => $phone,
        'email' => $phone,
    ];
});
