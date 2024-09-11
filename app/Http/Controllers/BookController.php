<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;



class BookController extends Controller
{
    // Show the list of books
    public function index()
    {
        $books = Book::all(); // Fetch all books from the database
        return response()->json($books); // Return the data as JSON
    }

    // Show the details of a single book
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return Inertia::render('BookDetail', [
            'book' => $book,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}

