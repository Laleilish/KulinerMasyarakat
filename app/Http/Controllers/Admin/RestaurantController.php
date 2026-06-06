<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Services\CloudinaryService;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the restaurants.
     */
    public function index(Request $request)
    {
        $query = Restaurant::with(['user', 'campus'])->latest();

        if ($request->filled('campus')) {
            $query->where('campus_id', $request->campus);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $restaurants = $query->paginate(10)->appends($request->query());
        $campuses = Campus::orderBy('name')->get();
        $categories = Restaurant::select('category')->distinct()->pluck('category');

        return view('admin.restaurants.index', compact('restaurants', 'campuses', 'categories'));
    }

    /**
     * Show the form for creating a new restaurant.
     */
    public function create()
    {
        $campuses = Campus::orderBy('name')->get();
        return view('admin.restaurants.create', compact('campuses'));
    }

    /**
     * Store a newly created restaurant in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'campus_id' => 'required|exists:campuses,id',
            'category' => 'required|string|max:255',
            'food_type' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'open_hours' => 'required|string|max:255',
            'price_range' => 'required|string|max:255',
            'gmaps_link' => 'required|url|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'landmark' => 'nullable|string|max:255',
            'landmark_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = CloudinaryService::upload($request->file('image'), 'restaurants');
        }

        if ($request->hasFile('landmark_photo')) {
            $validated['landmark_photo'] = CloudinaryService::upload($request->file('landmark_photo'), 'restaurants/landmarks');
        }

        // Set user_id to current admin for directly created restaurants
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'approved';
        $validated['rating'] = 0;

        Restaurant::create($validated);

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restoran berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified restaurant.
     */
    public function edit(Restaurant $restaurant)
    {
        $campuses = Campus::orderBy('name')->get();
        return view('admin.restaurants.edit', compact('restaurant', 'campuses'));
    }

    /**
     * Update the specified restaurant in storage.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'campus_id' => 'required|exists:campuses,id',
            'category' => 'required|string|max:255',
            'food_type' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'open_hours' => 'required|string|max:255',
            'price_range' => 'required|string|max:255',
            'gmaps_link' => 'required|url|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'landmark' => 'nullable|string|max:255',
            'landmark_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($restaurant->image) {
                CloudinaryService::delete($restaurant->image);
            }
            $validated['image'] = CloudinaryService::upload($request->file('image'), 'restaurants');
        }

        if ($request->hasFile('landmark_photo')) {
            if ($restaurant->landmark_photo) {
                CloudinaryService::delete($restaurant->landmark_photo);
            }
            $validated['landmark_photo'] = CloudinaryService::upload($request->file('landmark_photo'), 'restaurants/landmarks');
        }

        $restaurant->update($validated);

        return redirect()->route('admin.restaurants.edit', $restaurant)
            ->with('success', 'Data restoran berhasil diperbarui.');
    }

    /**
     * Remove the specified restaurant from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        if ($restaurant->image) {
            CloudinaryService::delete($restaurant->image);
        }
        if ($restaurant->landmark_photo) {
            CloudinaryService::delete($restaurant->landmark_photo);
        }
        
        $restaurant->delete();

        return redirect()->route('admin.restaurants.index')
            ->with('success', 'Restoran berhasil dihapus.');
    }
}
