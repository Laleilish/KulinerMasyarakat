<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Restaurant;
use App\Services\RestaurantService;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    protected RestaurantService $restaurantService;

    public function __construct(RestaurantService $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function index()
    {
        $restaurants = Restaurant::latest()->paginate(12);
        return view('restaurants.index', compact('restaurants'));
    }

    public function show(Restaurant $restaurant)
    {
        if ($restaurant->status !== 'approved') {
            abort(404);
        }

        $restaurant = $this->restaurantService->getDetail($restaurant);
        $relatedRestaurants = $this->restaurantService->getRelated($restaurant);

        $hasReviewed = false;

        if (auth()->check()) {
            $hasReviewed = $restaurant->reviews
                ->where('user_id', auth()->id())
                ->isNotEmpty();
        }

        return view('restorant.show', compact(
            'restaurant',
            'relatedRestaurants',
            'hasReviewed'
        ));
    }

    public function tanggalTua()
    {
        // Ambil restoran approved dengan harga di bawah 15k, pola sama seperti landing page
        $restaurants = Restaurant::approved()
            ->tanggalTua()
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->orderBy('reviews_count', 'desc')
            ->get();

        // Ambil semua kampus untuk location selector (sama seperti hidden gem)
        $campuses = Campus::all();

        $campusesData = $campuses->map(fn($c) => [
            'id'        => $c->id,
            'name'      => $c->name,
            'logo'      => asset('assets/img/kampus/' . $c->logo),
            'latitude'  => (float) $c->latitude,
            'longitude' => (float) $c->longitude,
        ])->values();

        return view('tanggal-tua.index', compact('restaurants', 'campuses', 'campusesData'));
    }
}