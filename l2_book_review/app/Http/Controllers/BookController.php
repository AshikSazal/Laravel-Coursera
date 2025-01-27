<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
// use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $filter = $request->input('filter', '');
        $books = Book::when($title, fn ($query, $title) => $query->title($title));

        // match works like switch case
        $books = match ($filter) {
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6months' => $books->popularLast6Months(),
            'highest_rated_last_month' => $books->highestRatedLastMonth(),
            'highest_rated_last_6months' => $books->highestRatedLast6Months(),
            default => $books->latest()->withAvgRating()->withReviewsCount()
        };
        // $books = $books->get();

        $cacheKey = 'books:' . $filter . ':' . $title;
        // key, 1hour=> how long cache value will be stored, function which will get the data
        // It's not good to use Cache memory
        // $books = Cache::remember($cacheKey, 3600, fn()=>$books->get());
        // $books = cache()->remember($cacheKey, 3600, fn () => $books->get());


        $books = $books->get();

        return view('books.index', ["books" => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //1.
        //  return view('books.show', ['book'=>$book]);

        //2.
        //  return view(
        //     'books.show',
        //     [
        //         'book' => $book->load([
        //             'reviews' => fn ($query) => $query->latest()
        //         ])
        //     ]
        // );

        // 3.
        $cachekey = 'book:' . $id;
        $book = cache()->remember($cachekey, 3600, fn () => Book::with([
            'reviews' => fn ($query) => $query->latest()
        ])->withAvgRating()->withReviewsCount()->findOrFail($id));
        return view('books.show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
