<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Exception;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::truncate();; // Optional: clears old data

        $categories = collect([
            ['name' => 'Technology',     'slug' => 'technology',     'description' => 'Posts related to the latest tech trends and innovations.'],
            ['name' => 'Health',         'slug' => 'health',         'description' => 'Health tips, medical news, and wellness advice.'],
            ['name' => 'Education',      'slug' => 'education',      'description' => 'Content about learning, schools, and academic news.'],
            ['name' => 'Travel',         'slug' => 'travel',         'description' => 'Travel guides, tips, and destination recommendations.'],
            ['name' => 'Food',           'slug' => 'food',           'description' => 'Recipes, cooking tips, and food reviews.'],
            ['name' => 'Finance',        'slug' => 'finance',        'description' => 'Financial advice, investment tips, and economic news.'],
            ['name' => 'Entertainment',  'slug' => 'entertainment',  'description' => 'Movies, music, and pop culture updates.'],
            ['name' => 'Sports',         'slug' => 'sports',         'description' => 'News and updates on local and international sports.'],
            ['name' => 'Lifestyle',      'slug' => 'lifestyle',      'description' => 'Personal development, home life, and hobbies.'],
            ['name' => 'Politics',       'slug' => 'politics',       'description' => 'Political news, opinions, and analysis.'],
            ['name' => 'Science',        'slug' => 'science',        'description' => 'Scientific discoveries, research, and technology.'],
            ['name' => 'Business',       'slug' => 'business',       'description' => 'Industry news, company updates, and entrepreneurship.'],
            ['name' => 'Art',            'slug' => 'art',            'description' => 'Creative expression through various art forms.'],
            ['name' => 'Culture',        'slug' => 'culture',        'description' => 'Insights into global and local cultures.'],
            ['name' => 'Fashion',        'slug' => 'fashion',        'description' => 'Trends, tips, and news from the fashion world.'],
            ['name' => 'Environment',    'slug' => 'environment',    'description' => 'Climate change, conservation, and green living.'],
            ['name' => 'Real Estate',    'slug' => 'real-estate',    'description' => 'Housing market news and property advice.'],
            ['name' => 'Automotive',     'slug' => 'automotive',     'description' => 'Cars, bikes, and the auto industry.'],
            ['name' => 'History',        'slug' => 'history',        'description' => 'Historical events, facts, and stories.'],
            ['name' => 'DIY',            'slug' => 'diy',            'description' => 'Do-it-yourself projects and tutorials.'],
        ]);

        try {
            DB::beginTransaction();
            $categories->map(fn($category) => Category::query()->create($category));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
