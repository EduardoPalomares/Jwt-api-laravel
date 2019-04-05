<?php

use Faker\Generator as Faker;

$factory->define(App\Producto::class, function (Faker $faker) {
    return [
      'name'             => $faker->sentence,
      'description'     => $faker->text(100),
    ];
});
