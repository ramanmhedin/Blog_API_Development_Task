<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Faker\Factory;
use http\Exception\RuntimeException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{

    public function run(): void
    {

        $authorIds = User::pluck('id')->toArray();
        $categoryIds = Category::pluck('id')->toArray();

        $faker = Factory::create();

        //I used the create method to user the Triggers Events (created).
        DB::beginTransaction();

        try {
            foreach (range(1, 50) as $i) {
                Post::query()
                    ->create(
                        [
                            'title' => $faker->sentence(6),
                            'content' => $faker->paragraphs(3, true),
                            'author_id' => $faker->randomElement($authorIds),
                            'category_id' => $faker->randomElement($categoryIds),
                        ]);
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
