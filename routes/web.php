<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/blog/{slug}', [FrontController::class, 'blog'])->name('blog');
Route::post('/comment_submit', [FrontController::class, 'comment_submit'])->name('comment_submit');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Blogs     
    Route::get('/blogs_view', [BlogController::class, 'index'])->name('blogs_view');
    Route::get('/blogs_show/{id}', [BlogController::class, 'show'])->name('blogs.show');
    Route::get('/blogs_create', [BlogController::class, 'create'])->name('blogs.create');
    Route::get('/blogs_import_rss', [BlogController::class, 'import_rss'])->name('blogs.import.rss');
    Route::post('/blogs_import_rss_submit', [BlogController::class, 'import_rss_submit'])->name('blogs.import.rss_submit');
    Route::get('/blogs_import_csv', [BlogController::class, 'import_csv'])->name('blogs.import.csv');
    Route::post('/blogs_import_csv_submit', [BlogController::class, 'import_csv_submit'])->name('blogs.import.csv_submit');
    Route::get('/blogs_edit/{id}', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::post('/blogs_store', [BlogController::class, 'store'])->name('blogs.store');
    Route::put('/blogs_update/{id}', [BlogController::class, 'update'])->name('blogs_update');
    Route::get('/blogs_delete/{id}', [BlogController::class, 'destroy'])->name('blogs_destroy');
    
    //Users     
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
