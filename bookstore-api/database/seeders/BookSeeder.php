<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'category' => 'programming',
                'price' => 35.00,
                'stock' => 10,
                'description' => 'A handbook of agile software craftsmanship.',
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'author' => 'David Thomas',
                'category' => 'programming',
                'price' => 40.00,
                'stock' => 8,
                'description' => 'Practical advice for becoming a better programmer.',
            ],
            [
                'title' => 'Rich Dad Poor Dad',
                'author' => 'Robert Kiyosaki',
                'category' => 'business',
                'price' => 25.00,
                'stock' => 15,
                'description' => 'A book about financial education and investing.',
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'category' => 'self-development',
                'price' => 30.00,
                'stock' => 12,
                'description' => 'A guide to building good habits.',
            ],
        ];

        foreach ($books as $book) {
            $category = Category::where(
                'slug',
                $book['category']
            )->firstOrFail();

            Book::updateOrCreate(
                ['slug' => Str::slug($book['title'])],
                [
                    'category_id' => $category->id,
                    'title' => $book['title'],
                    'slug' => Str::slug($book['title']),
                    'author' => $book['author'],
                    'price' => $book['price'],
                    'stock' => $book['stock'],
                    'description' => $book['description'],
                ]
            );
        }
    }
}
