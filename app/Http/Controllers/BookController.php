<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;



class BookController extends Controller
{
    // Show the list of books
    public function index(Request $request)
    {
        // Get the search query from the request
        $search = $request->input('search');

        // If search is present, filter the books by name or description
        $books = Book::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('description', 'like', "%{$search}%");
            })
            ->get();

            return response()->json($books);
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

