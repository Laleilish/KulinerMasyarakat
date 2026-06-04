<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Restaurant;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class HiddenGemController extends Controller
{
    private function mapRestaurant($r, $campus = null): array
    {
        $distance = $r->distance ?? '—';
        
        if ($campus && $r->latitude && $r->longitude) {
            $earthRadius = 6371;
            $lat1 = $campus->latitude;
            $lon1 = $campus->longitude;
            $lat2 = $r->latitude;
            $lon2 = $r->longitude;
            
            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);
            
            $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $km = $earthRadius * $c;

            if ($km < 1) {
                $distance = round($km * 1000) . ' m';
            } elseif ($km < 10) {
                $distance = number_format($km, 1, '.', '') . ' km';
            } else {
                $distance = round($km) . ' km';
            }
        }

        return [
            'id'          => $r->id,
            'name'        => $r->name,
            'image'       => asset('assets/img/resto/' . $r->image),
            'description' => $r->description ?? '',
            'rating'      => $r->rating,
            'distance'    => $distance,
            'price_range' => $r->price_range,
            'category'    => $r->category,
            'food_type'   => $r->food_type,
            'address'     => $r->address,
            'open_hours'  => $r->open_hours,
            'gmaps_link'  => $r->gmaps_link,
            'latitude'    => (float) $r->latitude,
            'longitude'   => (float) $r->longitude,
            'is_featured' => $r->is_featured,
        ];
    }

    public function index(): View
    {
        $campuses = Campus::all();

        $campusesData = $campuses->map(fn($c) => [
            'id' => $c->id,
            'name' => $c->name,
            'logo' => asset('assets/img/kampus/' . $c->logo),
            'latitude' => (float) $c->latitude,
            'longitude' => (float) $c->longitude,
            'zoom' => $c->map_zoom,
        ])->values();

        $selectedCampus = $campuses->first();

        // Hanya restoran featured, max 5, rating tertinggi
        $featuredRestaurants = Restaurant::where('campus_id', $selectedCampus->id)
            ->where('is_featured', true)
            ->orderByDesc('rating')
            ->take(10)
            ->get()
            ->map(fn($r) => $this->mapRestaurant($r, $selectedCampus));

        // Semua restoran, rating tertinggi
        $topRestaurants = Restaurant::orderByDesc('rating')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn($r) => $this->mapRestaurant($r, $selectedCampus));

        return view('hidden-gem.index', compact(
            'campuses',
            'campusesData',
            'selectedCampus',
            'featuredRestaurants',
            'topRestaurants',
        ));
    }

    public function getRestaurants(int $campusId): JsonResponse
    {
        $campus = Campus::findOrFail($campusId);

        $restaurants = Restaurant::where('campus_id', $campusId)
            ->orderByDesc('rating')
            ->get()
            ->map(fn($r) => $this->mapRestaurant($r, $campus));

        $featuredRestaurants = Restaurant::where('campus_id', $campusId)
            ->where('is_featured', true)
            ->orderByDesc('rating')
            ->take(10)
            ->get()
            ->map(fn($r) => $this->mapRestaurant($r, $campus));

        return response()->json([
            'campus' => [
                'id' => $campus->id,
                'name' => $campus->name,
                'latitude' => (float) $campus->latitude,
                'longitude' => (float) $campus->longitude,
                'zoom' => $campus->map_zoom,
            ],
            'restaurants' => $restaurants,
            'featuredRestaurants' => $featuredRestaurants,
        ]);
    }
}