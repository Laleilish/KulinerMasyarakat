<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\SubmitPlace;
use App\Notifications\PlaceApprovedNotification;
use App\Notifications\PlaceRejectedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SubmitPlaceController extends Controller
{
    /**
     * Display a listing of submitted places.
     */
    public function index(Request $request)
    {
        $query = SubmitPlace::with(['user', 'campus'])
            ->latest();

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by campus
        if ($request->filled('campus')) {
            $query->where('campus_id', $request->campus);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $submitPlaces = $query->paginate(10)
            ->appends($request->query());

        // Stats cards — real data
        $totalRestoTerdaftar = Restaurant::count();
        $usulanTertunda = SubmitPlace::pending()->count();

        // Kampus favorit
        $topCampus = Campus::withCount('restaurants')
            ->orderByDesc('restaurants_count')
            ->first();

        // Daftar kampus 
        $campuses = Campus::orderBy('name')->get();
        $categories = SubmitPlace::select('category')->distinct()->pluck('category');

        return view('admin.submit-places.index', compact(
            'submitPlaces',
            'totalRestoTerdaftar',
            'usulanTertunda',
            'topCampus',
            'campuses',
            'categories',
        ));
    }

    /**
     * Display the specified submitted place.
     */
    public function show(SubmitPlace $submitPlace)
    {
        $submitPlace->load(['user', 'campus']);

        return view('admin.submit-places.show', compact('submitPlace'));
    }

    /**
     * Show the form for editing the specified submitted place.
     */
    public function edit(SubmitPlace $submitPlace)
    {
        $campuses = Campus::orderBy('name')->get();
        return view('admin.submit-places.edit', compact('submitPlace', 'campuses'));
    }

    /**
     * Update the specified submitted place in storage.
     */
    public function update(Request $request, SubmitPlace $submitPlace)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'campus_id' => 'required|exists:campuses,id',
            'category' => 'required|string|max:255',
            'food_type' => 'nullable|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'open_hours' => 'nullable|string|max:255',
            'price_range' => 'nullable|string|max:255',
            'gmaps_link' => 'nullable|url|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'landmark' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($submitPlace->photo) {
                Storage::disk('public')->delete($submitPlace->photo);
            }
            $validated['photo'] = $request->file('photo')->store('submit-places', 'public');
        } else {
            unset($validated['photo']);
        }

        $isApproved = $submitPlace->status === 'approved';

        $submitPlace->update($validated);

        // Sync to Restaurant if already approved
        if ($isApproved) {
            $restaurant = Restaurant::where('user_id', $submitPlace->user_id)
                ->where('campus_id', $submitPlace->campus_id)
                ->first();

            if ($restaurant) {
                $syncData = [
                    'name' => $submitPlace->name,
                    'campus_id' => $submitPlace->campus_id,
                    'category' => $submitPlace->category,
                    'food_type' => $submitPlace->food_type,
                    'description' => $submitPlace->description,
                    'address' => $submitPlace->address,
                    'open_hours' => $submitPlace->open_hours,
                    'price_range' => $submitPlace->price_range,
                    'gmaps_link' => $submitPlace->gmaps_link,
                    'latitude' => $submitPlace->latitude,
                    'longitude' => $submitPlace->longitude,
                    'landmark' => $submitPlace->landmark,
                ];

                // Also sync photo if it was changed
                if (isset($validated['photo'])) {
                    $syncData['image'] = $submitPlace->photo;
                }

                $restaurant->update($syncData);
            }
        }

        return redirect()->route('admin.submit-places.edit', $submitPlace)
            ->with('success', 'Data berhasil diperbarui.' . ($isApproved ? ' Perubahan juga telah disinkronkan ke restoran yang terbit.' : ''));
    }

    /**
     * Remove the specified submitted place from storage.
     */
    public function destroy(SubmitPlace $submitPlace)
    {
        $submitPlace->delete();

        return redirect()->route('admin.submit-places.index')
            ->with('success', 'Usulan tempat berhasil dihapus sepenuhnya.');
    }

    /**
     * Approve a submitted place.
     * Creates a new restaurant and an initial review from the submitter.
     */
    public function approve(SubmitPlace $submitPlace)
    {
        DB::transaction(function () use ($submitPlace) {
            // Create restaurant from submit_place data
            $restaurant = Restaurant::create([
                'user_id'        => $submitPlace->user_id,
                'campus_id'      => $submitPlace->campus_id,
                'name'           => $submitPlace->name,
                'category'       => $submitPlace->category,
                'food_type'      => $submitPlace->food_type,
                'image'          => $submitPlace->photo,
                'description'    => $submitPlace->description,
                'address'        => $submitPlace->address,
                'open_hours'     => $submitPlace->open_hours,
                'price_range'    => $submitPlace->price_range,
                'gmaps_link'     => $submitPlace->gmaps_link,
                'latitude'       => $submitPlace->latitude,
                'longitude'      => $submitPlace->longitude,
                'landmark'       => $submitPlace->landmark,
                'landmark_photo' => $submitPlace->landmark_photo,
                'status'         => 'approved',
                'rating'         => $submitPlace->initial_rating,
            ]);

            // Create initial review from the submitter
            Review::create([
                'user_id'       => $submitPlace->user_id,
                'restaurant_id' => $restaurant->id,
                'rating'        => $submitPlace->initial_rating,
                'comment'       => $submitPlace->initial_review,
                'photos'        => $submitPlace->initial_review_photos,
            ]);

            // Mark submit place as approved
            $submitPlace->update(['status' => 'approved']);

            // Notify the user
            $submitPlace->user->notify(new PlaceApprovedNotification($submitPlace));
        });

        return redirect()->back()
            ->with('success', 'Tempat berhasil disetujui dan ditambahkan ke daftar restoran.');
    }

    /**
     * Reject a submitted place.
     */
    public function reject(SubmitPlace $submitPlace)
    {
        $submitPlace->update(['status' => 'rejected']);

        // Notify the user
        $submitPlace->user->notify(new PlaceRejectedNotification($submitPlace));

        return redirect()->back()
            ->with('success', 'Usulan tempat telah ditolak.');
    }
}
