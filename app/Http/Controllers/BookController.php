<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;




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

    public function toggleFavorite(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user
        Log::info('Current user:', ['user' => $user]);
    
        // Get book_id from the request payload
        $bookId = $request->input('book_id');
    
        // Find the book by ID
        $book = Book::findOrFail($bookId); // Check if the book exists
    
        if ($user->favorites()->where('book_id', $bookId)->exists()) {
            // If it exists, remove it from favorites
            $user->favorites()->detach($bookId);
            Log::info('Book removed from favorites: ' . $bookId);
        } else {
            // If it doesn't exist, add it to favorites
            $user->favorites()->attach($bookId);
            Log::info('Book added to favorites: ' . $bookId);
        }
    
        // Return a JSON response indicating whether it's now a favorite
        return response()->json([
            'is_favorite' => $user->favorites()->where('book_id', $bookId)->exists()
        ]);
    }
}

