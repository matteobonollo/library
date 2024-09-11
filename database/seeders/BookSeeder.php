<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run()
    {
        // Example book data
        $books = [
            [
                'name' => 'The Great Gatsby',
                'description' => 'A novel by F. Scott Fitzgerald set in the Roaring Twenties.',
                'image' => 'path/to/great-gatsby.jpg',
                'price' => 10.99,
            ],
            [
                'name' => '1984',
                'description' => 'A dystopian social science fiction novel and cautionary tale by George Orwell.',
                'image' => 'path/to/1984.jpg',
                'price' => 8.99,
            ],
            [
                'name' => 'To Kill a Mockingbird',
                'description' => 'A novel by Harper Lee published in 1960. It was immediately successful, winning the Pulitzer Prize.',
                'image' => 'path/to/to-kill-a-mockingbird.jpg',
                'price' => 12.99,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
