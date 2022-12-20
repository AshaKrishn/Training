<?php

use App\Http\Controllers\BookController;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [BookController::class,'index']);

Route::get('books/{book}', [BookController::class,'show']);

Route::get('search', [BookController::class,'index']);

Route::get('categories/{category:slug}', function (Category $category) {
    return view('books', [
        'books' => $category->book
    ]);
});

Route::get('authors/{author:slug}', function (Author $author) {
    return view('books', [
        'books' => $author->book
    ]);
});

/*
Route::get('books/{book}', function ($id) {
    return view('book', [
        'books' => Book::findOrFail($id)
    ]);
});
*/
