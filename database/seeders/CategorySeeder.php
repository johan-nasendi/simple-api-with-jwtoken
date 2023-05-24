<?php

namespace Database\Seeders;

use App\Models\Core\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Categories::insert([
            [
                'author' => 1,
                'name' => 'Informasi',
                'slug' => 'informasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'author' => 1,
                'name' => 'berita',
                'slug' => 'beria',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'author' => 2,
                'name' => 'Laravel',
                'slug' => 'laravel',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'author' => 2,
                'name' => 'HTML',
                'slug' => 'html',
                'created_at' => now(),
                'updated_at' => now(),
            ]
       ]);
    }
}
