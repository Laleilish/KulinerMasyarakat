<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HiddenGemController;
use App\Http\Controllers\RestaurantController;

Route::get('/', fn () => view('home.index'))->name('home');
Route::get('/hidden-gem', [HiddenGemController::class, 'index'])->name('hidden-gem');
Route::get('/hidden-gem/restaurants/{campus_id}', [HiddenGemController::class, 'getRestaurants'])->name('hidden-gem.restaurants');
Route::get('/semua-resto', [RestaurantController::class, 'index'])->name('semua-resto'); 
Route::get('/tanggal-tua', fn() => view('tanggal-tua.index'))->name('tanggal-tua.index');
Route::get('/terserah', fn() => view('terserah.index'))->name('terserah.index');
Route::get('/proposal', fn() => view('submit-place.create'))->name('submit-place.create');
Route::get('/split-bill', fn() => view('split-bill.index'))->name('split-bill.index');

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/logout', fn() => redirect('/'))->name('logout');

Route::get('/auth/{provider}/redirect', fn($provider) => back())
    ->name('social.redirect');