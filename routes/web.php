<?php

use App\Http\Controllers\PhoneBook\PhoneBookController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('/phone-book')->middleware(['auth', 'verified'])->group(function (){
    Route::get('/dashboard', [PhoneBookController::class, 'index'])->name('dashboard');
    Route::get('/favorite', [PhoneBookController::class, 'favorite'])->name('favorite');
    Route::get('/create-contact', [PhoneBookController::class, 'create'])->name('create.contact');
    Route::get('/contact/{id}', [PhoneBookController::class, 'show'])->name('show.contact');
    Route::get('/edit-contact/{id}', [PhoneBookController::class, 'edit'])->name('edit.contact');
});

require __DIR__.'/auth.php';
