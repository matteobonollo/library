<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    // Show the list of books
    public function index()
    {
        $books = Book::all(); // You might want to paginate or filter this data
        return Inertia::render('BooksIndex', [
            'books' => $books,
        ]);
    }

    // Show the details of a single book
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return Inertia::render('BookDetail', [
            'book' => $book,
        ]);
    }
}

