<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminBookController extends Controller
{
    public function index()
    {
        return Book::with('category')
            ->latest()
            ->paginate(15);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'cover' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);

        if ($request->hasFile('cover')) {
            $data['cover_image'] = $request->file('cover')
                ->store('books', 'public');
        }

        unset($data['cover']);

        $book = Book::create($data);

        return response()->json($book, 201);
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'cover' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('cover')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $data['cover_image'] = $request->file('cover')
                ->store('books', 'public');
        }

        unset($data['cover']);

        if ($book->title !== $data['title']) {
            $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);
        }

        $book->update($data);

        return response()->json($book);
    }

    public function destroy(Book $book)
    {
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully',
        ]);
    }
}
