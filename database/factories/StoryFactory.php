<?php

use Faker\Generator as Faker;

$factory->define(App\Story::class, function (Faker $faker) {
  return [
    'title' => $faker->word . " " . $faker->word,
    'subtitle' => $faker->sentence(10),
    'description' => $faker->paragraph(200),
    'image' => 'uploads/placehold.png',
    'user_id' => 1,
    'category_id' => 1
  ];
});
