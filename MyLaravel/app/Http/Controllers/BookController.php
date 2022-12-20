<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index() 
    {
        return view('books', [
            'books'=> Book::latest()->filter(request(['search']))->get()
        ]);
    }

    public function show(Book $book)
    {
        return view('book', [
            'books' => $book
        ]);
    }


}
