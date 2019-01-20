<?php

use Illuminate\Database\Seeder;

class StoriesTableSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    factory(App\Story::class, 10)->create();
  }
}
