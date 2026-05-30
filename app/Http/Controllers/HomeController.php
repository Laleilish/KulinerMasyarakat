<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get approved restaurants, ordered by average rating and then by number of reviews
        $restaurants = Restaurant::approved()
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->orderBy('reviews_count', 'desc')
            ->take(8)
            ->get();

        return view('home.index', compact('restaurants'));
    }
}
