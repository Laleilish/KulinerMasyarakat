<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::latest()->paginate(12);
        return view('restaurants.index', compact('restaurants'));
    }
}