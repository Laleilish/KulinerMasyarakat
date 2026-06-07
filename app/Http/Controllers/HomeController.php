<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua restoran approved, urutkan berdasarkan rating dan review
        $restaurants = \App\Models\Restaurant::approved()
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->orderBy('reviews_count', 'desc')
            ->get();

        // Ambil semua kampus untuk location selector
        $campuses = \App\Models\Campus::all();

        $campusesData = $campuses->map(fn($c) => [
            'id'        => $c->id,
            'name'      => $c->name,
            'logo'      => asset('assets/img/Kampus/' . $c->logo),
            'latitude'  => (float) $c->latitude,
            'longitude' => (float) $c->longitude,
        ])->values();

        return view('home.index', compact('restaurants', 'campuses', 'campusesData'));
    }
}
