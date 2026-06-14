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
        $query = Restaurant::with(['user', 'campus'])->withAvg('reviews', 'rating')->latest();

        if ($request->filled('campus')) {
            $query->where('campus_id', $request->campus);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $restaurants = $query->paginate(10)->appends($request->query());
        
        session(['admin_restaurants_url' => request()->fullUrl()]);
        
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
            'name' => 'required|string|min:2|max:100',
            'campus_id' => 'required|exists:campuses,id',
            'category' => 'required|in:makanan_berat,jajanan,minuman',
            'food_type' => 'required|string|min:2|max:100',
            'description' => 'required|string|max:1000',
            'address' => 'required|string|min:5|max:500',
            'open_hours' => 'required|string|max:50',
            'price_range' => 'required|string|max:100',
            'gmaps_link' => 'required|url|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'landmark' => 'nullable|string|max:255',
            'landmark_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.min' => 'Nama restoran minimal 2 karakter.',
            'name.max' => 'Nama restoran maksimal 100 karakter.',
            'category.in' => 'Kategori tidak valid.',
            'food_type.min' => 'Jenis makanan minimal 2 karakter.',
            'food_type.max' => 'Jenis makanan maksimal 100 karakter.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
            'address.min' => 'Alamat minimal 5 karakter.',
            'address.max' => 'Alamat maksimal 500 karakter.',
            'open_hours.max' => 'Jam buka maksimal 50 karakter.',
            'price_range.max' => 'Range harga maksimal 100 karakter.',
            'gmaps_link.max' => 'Link Google Maps terlalu panjang.',
            'latitude.between' => 'Latitude harus antara -90 dan 90.',
            'longitude.between' => 'Longitude harus antara -180 dan 180.',
            'image.max' => 'Ukuran foto maksimal 2MB.',
            'landmark_photo.max' => 'Ukuran foto patokan maksimal 2MB.',
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

        return redirect(session('admin_restaurants_url', route('admin.restaurants.index')))
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
            'name' => 'required|string|min:2|max:100',
            'campus_id' => 'required|exists:campuses,id',
            'category' => 'required|in:makanan_berat,jajanan,minuman',
            'food_type' => 'required|string|min:2|max:100',
            'description' => 'required|string|max:1000',
            'address' => 'required|string|min:5|max:500',
            'open_hours' => 'required|string|max:50',
            'price_range' => 'required|string|max:100',
            'gmaps_link' => 'required|url|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'landmark' => 'nullable|string|max:255',
            'landmark_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.min' => 'Nama restoran minimal 2 karakter.',
            'name.max' => 'Nama restoran maksimal 100 karakter.',
            'category.in' => 'Kategori tidak valid.',
            'food_type.min' => 'Jenis makanan minimal 2 karakter.',
            'food_type.max' => 'Jenis makanan maksimal 100 karakter.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
            'address.min' => 'Alamat minimal 5 karakter.',
            'address.max' => 'Alamat maksimal 500 karakter.',
            'open_hours.max' => 'Jam buka maksimal 50 karakter.',
            'price_range.max' => 'Range harga maksimal 100 karakter.',
            'gmaps_link.max' => 'Link Google Maps terlalu panjang.',
            'latitude.between' => 'Latitude harus antara -90 dan 90.',
            'longitude.between' => 'Longitude harus antara -180 dan 180.',
            'image.max' => 'Ukuran foto maksimal 2MB.',
            'landmark_photo.max' => 'Ukuran foto patokan maksimal 2MB.',
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

        return redirect(session('admin_restaurants_url', route('admin.restaurants.index')))
            ->with('success', 'Restoran berhasil dihapus.');
    }
}
