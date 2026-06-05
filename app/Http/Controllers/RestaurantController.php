<?php

namespace App\Http\Controllers;

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
}