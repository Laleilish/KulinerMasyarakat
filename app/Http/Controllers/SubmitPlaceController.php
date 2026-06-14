<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\SubmitPlace;
use App\Models\User;
use App\Notifications\NewPlaceSuggestedNotification;
use App\Services\GoogleMapsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Services\CloudinaryService;

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
            'name'                   => 'required|string|min:2|max:100',
            'category'               => 'required|in:makanan_berat,jajanan,minuman',
            'food_type'              => 'required|string|min:2|max:100',
            'photo'                  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description'            => 'nullable|string|max:1000',
            'address'                => 'required|string|min:5|max:500',
            'open_hours'             => 'required|string|max:50',
            'price_range'            => 'required|string|max:100',
            'gmaps_link'             => 'required|url|max:2048',
            'latitude'               => 'nullable|numeric|between:-90,90',
            'longitude'              => 'nullable|numeric|between:-180,180',
            'landmark'               => 'nullable|string|max:255',
            'landmark_photo'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'initial_rating'         => 'required|integer|min:1|max:5',
            'initial_review'         => 'nullable|string|max:1000',
            'initial_review_photos'   => 'nullable|array|max:5',
            'initial_review_photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required'          => 'Nama restoran wajib diisi.',
            'name.min'               => 'Nama restoran minimal 2 karakter.',
            'name.max'               => 'Nama restoran maksimal 100 karakter.',
            'category.required'      => 'Kategori wajib dipilih.',
            'category.in'            => 'Kategori tidak valid.',
            'food_type.required'     => 'Jenis makanan wajib diisi.',
            'food_type.min'          => 'Jenis makanan minimal 2 karakter.',
            'food_type.max'          => 'Jenis makanan maksimal 100 karakter.',
            'photo.required'         => 'Foto restoran wajib diupload.',
            'photo.image'            => 'File harus berupa gambar.',
            'photo.mimes'            => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'photo.max'              => 'Ukuran foto maksimal 2MB.',
            'description.max'        => 'Deskripsi maksimal 1000 karakter.',
            'address.required'       => 'Alamat wajib diisi.',
            'address.min'            => 'Alamat minimal 5 karakter.',
            'address.max'            => 'Alamat maksimal 500 karakter.',
            'open_hours.required'    => 'Jam buka wajib diisi.',
            'open_hours.max'         => 'Jam buka maksimal 50 karakter.',
            'price_range.required'   => 'Range harga wajib diisi.',
            'price_range.max'        => 'Range harga maksimal 100 karakter.',
            'gmaps_link.required'    => 'Link Google Maps wajib diisi.',
            'gmaps_link.url'         => 'Link Google Maps harus berupa URL yang valid.',
            'gmaps_link.max'         => 'Link Google Maps terlalu panjang.',
            'latitude.between'       => 'Latitude harus antara -90 dan 90.',
            'longitude.between'      => 'Longitude harus antara -180 dan 180.',
            'landmark.max'           => 'Patokan maksimal 255 karakter.',
            'landmark_photo.required' => 'Foto patokan wajib diupload.',
            'landmark_photo.max'     => 'Ukuran foto patokan maksimal 2MB.',
            'initial_rating.required' => 'Rating wajib dipilih.',
            'initial_rating.min'     => 'Rating minimal 1.',
            'initial_rating.max'     => 'Rating maksimal 5.',
            'initial_review.max'     => 'Review maksimal 1000 karakter.',
            'initial_review_photos.max' => 'Foto review maksimal 5 file.',
            'initial_review_photos.*.max' => 'Ukuran foto review maksimal 2MB.',
        ]);

        // Upload photos
        $photoPath = CloudinaryService::upload($request->file('photo'), 'submit-places');
        $landmarkPhotoPath = CloudinaryService::upload($request->file('landmark_photo'), 'submit-places');

        $reviewPhotoPaths = [];
        if ($request->hasFile('initial_review_photos')) {
            foreach ($request->file('initial_review_photos') as $file) {
                $reviewPhotoPaths[] = CloudinaryService::upload($file, 'submit-places');
            }
        }

        // Use submitted coordinates if available, otherwise extract from link
        if (!empty($validated['latitude']) && !empty($validated['longitude'])) {
            $latitude  = $validated['latitude'];
            $longitude = $validated['longitude'];
        } else {
            $mapsService = new GoogleMapsService();
            $coordinates = $mapsService->extractCoordinates($validated['gmaps_link']);
            $latitude  = $coordinates['latitude'] ?? null;
            $longitude = $coordinates['longitude'] ?? null;
        }

        // Find nearest campus using Haversine formula
        $campusId = $this->findNearestCampus($latitude, $longitude);

        // Save submit place
        $submitPlace = SubmitPlace::create([
            'user_id'              => Auth::id(),
            'campus_id'            => $campusId,
            'name'                 => $validated['name'],
            'category'             => $validated['category'],
            'food_type'            => $validated['food_type'],
            'photo'                => $photoPath,
            'description'          => $validated['description'] ?? null,
            'address'              => $validated['address'],
            'open_hours'           => $validated['open_hours'],
            'price_range'          => $validated['price_range'],
            'gmaps_link'           => $validated['gmaps_link'],
            'latitude'             => $latitude,
            'longitude'            => $longitude,
            'landmark'             => $validated['landmark'] ?? null,
            'landmark_photo'       => $landmarkPhotoPath,
            'initial_rating'       => $validated['initial_rating'],
            'initial_review'       => $validated['initial_review'] ?? null,
            'initial_review_photos' => !empty($reviewPhotoPaths) ? $reviewPhotoPaths : null,
            'status'               => 'pending',
        ]);

        // Notify admins
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewPlaceSuggestedNotification($submitPlace));

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
