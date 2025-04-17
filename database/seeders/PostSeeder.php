<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 12) as $index) {
            Post::updateOrCreate(
                ['slug' => $faker->slug], 
                [
                    'title'     => $faker->sentence(5),
                    'category'  => $faker->word,
                    'content'   => $faker->paragraph(3),
                ]
            );
        }
    }
}
