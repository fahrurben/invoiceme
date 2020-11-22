<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Domain\Item\Models\Item::class, function (Faker $faker, array $attributes) {
    $name =  isset($attributes['name']) ? $attributes['name'] : $faker->unique()->name();
    $type =  $attributes['type'] ?? 1;

    return [
        'companyId' => $attributes['companyId'],
        'name' => $name,
        'type' => $type,
        'category' => $attributes['category'],
        'isActive' => true,
    ];
});
