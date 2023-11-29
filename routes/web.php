<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $posts = Post::with('category', 'tags')->take(8)->latest()->get();
    return view('pages.home', compact('posts'));
});

Route::get('/posts',[App\Http\Controllers\PostController::class,'index'])->name('posts.index');
Route::get('/posts/{id}',[App\Http\Controllers\PostController::class,'show'])->name('posts.show');
Route::view('/about','pages.about')->name('about');


Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('tags', App\Http\Controllers\Admin\TagController::class);
    Route::resource('posts', App\Http\Controllers\Admin\PostController::class);
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
