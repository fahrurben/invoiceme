<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Domain\Item\Models\Category::class, function (Faker $faker, array $attributes) {
    $name =  isset($attributes['name']) ? $attributes['name'] : $faker->unique()->name();

    return [
        'companyId' => $attributes['companyId'],
        'name' => $name,
        'isActive' => true,
    ];
});
