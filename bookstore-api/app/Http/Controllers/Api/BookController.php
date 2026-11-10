<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index(Request $request)
    {
        $query = Book::with('category');

        $query->when($request->search, function ($query, $search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%");
        });

        $query->when($request->category, function ($query, $category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        });

        $books = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return BookResource::collection($books);
    }

    public function show(string $slug)
    {
        $book = Book::with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        return new BookResource($book);
    }
}
