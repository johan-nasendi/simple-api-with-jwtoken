<?php

namespace Database\Seeders;

use App\Models\Core\News;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        News::insert([
            [
                'author' => 1,
                'category_id' => 1,
                'title' => 'JavaScript Composer UI',
                'desc' => 'Laravel does not require you to use a specific JavaScript framework or library to build your applications. In fact, you dont have to use JavaScript at all. However, Laravel does include some basic scaffolding to make it easier to get started writing modern JavaScript using the Vue library. Vue provides an expressive API for building robust JavaScript applications using components. As with CSS, we may use Vite to easily compile JavaScript components into a single, browser-ready JavaScript file.',
                'brief_desc' => 'Laravel does not require you to use a specific JavaScript framework or library to build your applications',
                'slug' => 'javaScript-composer-ui',
                'created_at' => now(),
                'updated_at' => now(),
            ]
       ]);
    }
}
