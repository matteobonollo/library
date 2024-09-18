<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;





class BookController extends Controller
{
    // Show the list of books
    public function index(Request $request)
    {
        // Get the search query from the request
        $search = $request->input('search');
        $user = Auth::user();
    
        // Retrieve all books and apply search filters if provided
        $books = Book::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->get()
            ->map(function ($book) use ($user) {
                // Add favorite status if user is authenticated
                if ($user) {
                    $book->is_favorite = $user->favorites()->where('book_id', $book->id)->exists();
                } else {
                    $book->is_favorite = false; // Default to false if not authenticated
                }
                return $book;
            });
    
        return response()->json($books);
    }
    // Show the details of a single book
    public function show($id)
    {
        $book = Book::findOrFail($id);
        $user = Auth::user(); // Get the authenticated user

        // Check if the current book is a favorite of the authenticated user
        $isFavorite = $user && $user->favorites()->where('book_id', $id)->exists();

        return Inertia::render('BookDetail', [
            'book' => $book,
            'isFavorite' => $isFavorite,
        ]);
    }

    public function addFavorite(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user
        Log::info('Current user:', ['user' => $user]);

        try {
            // Get book_id from the request payload
            $bookId = $request->input('book_id');

            // Find the book by ID
            $book = Book::findOrFail($bookId); // Find the book, or throw an exception if not found
        } catch (ModelNotFoundException $e) {
            Log::error('Book not found: ' . $bookId);
            return response()->json(['error' => 'Book not found: ' . $bookId], 404);
        }

        if ($user->favorites()->where('book_id', $bookId)->exists()) {
            // If it already exists, return a response indicating it's already favorited
            return response()->json(['is_favorite' => true]);
        } else {
            // If it doesn't exist, add it to favorites
            $user->favorites()->attach($bookId);
            Log::info('Book added to favorites: ' . $bookId);
        }

        return response()->json(['is_favorite' => true]);
    }

    public function removeFavorite(Book $book)
    {
        $user = Auth::user(); // Get the authenticated user
        Log::info('Current user:', ['user' => $user]);

        try {
            // Find the book by ID
            $bookId = $book->id;
            $book = Book::findOrFail($bookId); // Ensure the book exists, or throw an exception
        } catch (ModelNotFoundException $e) {
            Log::error('Book not found: ' . $bookId);
            return response()->json(['error' => 'Book not found: ' . $bookId], 404);
        }

        if ($user->favorites()->where('book_id', $bookId)->exists()) {
            // If it exists, remove it from favorites
            $user->favorites()->detach($bookId);
            Log::info('Book removed from favorites: ' . $bookId);
        } else {
            // If it doesn't exist, return a response indicating it was not in favorites
            return response()->json(['is_favorite' => false]);
        }

        return response()->json(['is_favorite' => false]);
    }

    public function userFavorites($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $books = $user->favorites;

            return response()->json($books);
        } catch (ModelNotFoundException $e) {
            Log::error('User not found: ' . $userId);
            return response()->json(['error' => 'User not found'], 404);
        }
    }
}
