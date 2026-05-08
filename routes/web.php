<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
});


Route::get('/', fn () => view('home.index'))->name('home');
Route::get('/hidden-gem', fn() => view('hidden-gem.index'))->name('hidden-gem.index');
Route::get('/tanggal-tua', fn() => view('tanggal-tua.index'))->name('tanggal-tua.index');
Route::get('/terserah', fn() => view('terserah.index'))->name('terserah.index');
Route::get('/proposal', fn() => view('submit-place.create'))->name('submit-place.create');
Route::get('/split-bill', fn() => view('split-bill.index'))->name('split-bill.index');

require __DIR__.'/auth.php';
