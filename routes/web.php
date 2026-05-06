<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('home.index'))->name('home');
Route::get('/hidden-gem', fn() => view('hidden-gem.index'))->name('hidden-gem.index');
Route::get('/tanggal-tua', fn() => view('tanggal-tua.index'))->name('tanggal-tua.index');
Route::get('/terserah', fn() => view('terserah.index'))->name('terserah.index');
Route::get('/proposal', fn() => view('proposal.create'))->name('proposal.create');
Route::get('/split-bill', fn() => view('split-bill.index'))->name('split-bill.index');

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/logout', fn() => redirect('/'))->name('logout');

Route::get('/auth/{provider}/redirect', fn($provider) => back())
    ->name('social.redirect');
