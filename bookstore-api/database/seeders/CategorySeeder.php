<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Programming', 'slug' => 'programming'],
            ['name' => 'Business', 'slug' => 'business'],
            ['name' => 'Science', 'slug' => 'science'],
            ['name' => 'Self Development', 'slug' => 'self-development'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
