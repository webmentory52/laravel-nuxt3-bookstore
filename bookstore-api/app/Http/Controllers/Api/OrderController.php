<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:1000'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.book_id' => [
                'required',
                'integer',
                'distinct',
                'exists:books,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
                'max:20',
            ],
        ]);

        $order = DB::transaction(function () use ($validated) {
            $orderItems = [];
            $total = 0;

            // Lock and retrieve the selected books.
            $items = collect($validated['items'])
                ->sortBy('book_id');

            foreach ($items as $item) {
                $book = Book::whereKey($item['book_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($book->stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => [
                            "Insufficient stock for {$book->title}."
                        ],
                    ]);
                }

                $priceInCents = (int) round(
                    (float) $book->price * 100
                );

                $lineTotal = $priceInCents * $item['quantity'];

                $total += $lineTotal;

                $orderItems[] = [
                    'book' => $book,
                    'quantity' => $item['quantity'],
                ];
            }

            // Create the order.
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'total' => number_format($total / 100, 2, '.', ''),
                'status' => 'pending',
            ]);

            // Create order items and update stock.
            foreach ($orderItems as $item) {

                $book = $item['book'];
                $quantity = $item['quantity'];

                $order->items()->create([
                    'book_id' => $book->id,
                    'book_title' => $book->title,
                    'quantity' => $quantity,
                    'price' => $book->price,
                ]);

                $book->decrement('stock', $quantity);
            }

            return $order;

        });

        return response()->json([
            'message' => 'Order placed successfully.',
            'order' => $order->load('items'),
        ], 201);
    }
}
