<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\SubmitPlace;
use App\Services\GoogleMapsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmitPlaceController extends Controller
{
    /**
     * Show the form for creating a new submit place.
     */
    public function create()
    {
        return view('submit-place.create');
    }

    /**
     * Store a newly created submit place in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                 => 'required|string|max:255',
            'category'             => 'required|in:makanan_berat,jajanan,minuman',
            'food_type'            => 'nullable|string',
            'photo'                => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'description'          => 'nullable|string',
            'address'              => 'required|string',
            'open_hours'           => 'nullable|string',
            'price_range'          => 'nullable|string',
            'gmaps_link'           => 'required|url',
            'landmark'             => 'nullable|string',
            'landmark_photo'       => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'initial_rating'       => 'required|integer|min:1|max:5',
            'initial_review'       => 'nullable|string',
            'initial_review_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Upload photos
        $photoPath = $request->file('photo')
            ->store('submit-places', 'public');

        $landmarkPhotoPath = $request->file('landmark_photo')
            ->store('submit-places', 'public');

        $initialReviewPhotoPath = null;
        if ($request->hasFile('initial_review_photo')) {
            $initialReviewPhotoPath = $request->file('initial_review_photo')
                ->store('submit-places', 'public');
        }

        // Extract coordinates from Google Maps link
        $mapsService = new GoogleMapsService();
        $coordinates = $mapsService->extractCoordinates($validated['gmaps_link']);

        $latitude  = $coordinates['latitude'] ?? null;
        $longitude = $coordinates['longitude'] ?? null;

        // Find nearest campus using Haversine formula
        $campusId = $this->findNearestCampus($latitude, $longitude);

        // Save submit place
        SubmitPlace::create([
            'user_id'              => Auth::id(),
            'campus_id'            => $campusId,
            'name'                 => $validated['name'],
            'category'             => $validated['category'],
            'food_type'            => $validated['food_type'] ?? null,
            'photo'                => $photoPath,
            'description'          => $validated['description'] ?? null,
            'address'              => $validated['address'],
            'open_hours'           => $validated['open_hours'] ?? null,
            'price_range'          => $validated['price_range'] ?? null,
            'gmaps_link'           => $validated['gmaps_link'],
            'latitude'             => $latitude,
            'longitude'            => $longitude,
            'landmark'             => $validated['landmark'] ?? null,
            'landmark_photo'       => $landmarkPhotoPath,
            'initial_rating'       => $validated['initial_rating'],
            'initial_review'       => $validated['initial_review'] ?? null,
            'initial_review_photo' => $initialReviewPhotoPath,
            'status'               => 'pending',
        ]);

        return redirect()->route('home')
            ->with('success', 'Tempat berhasil diusulkan! Menunggu persetujuan admin.');
    }

    /**
     * Find the nearest campus to the given coordinates using the Haversine formula.
     *
     * @return int|null  Campus ID or null if no campuses exist or coordinates are null.
     */
    protected function findNearestCampus(?float $latitude, ?float $longitude): ?int
    {
        if ($latitude === null || $longitude === null) {
            // Fallback: return the first campus if coordinates are not available
            $firstCampus = Campus::first();
            return $firstCampus?->id;
        }

        $campuses = Campus::all();

        if ($campuses->isEmpty()) {
            return null;
        }

        $nearestCampus = null;
        $shortestDistance = PHP_FLOAT_MAX;

        foreach ($campuses as $campus) {
            $distance = $this->haversineDistance(
                $latitude,
                $longitude,
                (float) $campus->latitude,
                (float) $campus->longitude
            );

            if ($distance < $shortestDistance) {
                $shortestDistance = $distance;
                $nearestCampus = $campus;
            }
        }

        return $nearestCampus?->id;
    }

    /**
     * Calculate the distance between two points on Earth using the Haversine formula.
     *
     * @return float  Distance in kilometres.
     */
    protected function haversineDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
