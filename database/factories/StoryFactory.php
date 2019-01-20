<?php

use Faker\Generator as Faker;

$factory->define(App\Story::class, function (Faker $faker) {
  return [
    'title' => $faker->title,
    'subtitle' => $faker->sentence,
    'description' => $faker->paragraph,
    'image' => 'uploads/placehold.png',
    'user_id' => 1,
    'category_id' => 1
  ];
});
