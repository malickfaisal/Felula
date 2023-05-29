<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Users     
    Route::get('/users_view', [ProfileController::class, 'edit'])->name('users_view');

    //Blogs     
    Route::get('/blogs_view', [BlogController::class, 'index'])->name('blogs_view');
    Route::get('/blogs_show/{id}', [BlogController::class, 'show'])->name('blogs.show');
    Route::get('/blogs_create', [BlogController::class, 'create'])->name('blogs.create');
    Route::get('/blogs_edit/{id}', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::post('/blogs_store', [BlogController::class, 'store'])->name('blogs.store');
    Route::put('/blogs_update/{id}', [BlogController::class, 'update'])->name('blogs_update');
    Route::get('/blogs_delete/{id}', [BlogController::class, 'destroy'])->name('blogs_destroy');
});

require __DIR__.'/auth.php';
