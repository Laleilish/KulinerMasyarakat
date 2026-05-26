<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HiddenGemController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $campuses       = Campus::all();
        $selectedCampus = $campuses->first();
        $restaurants    = $selectedCampus
            ? $selectedCampus->restaurants()->orderByDesc('rating')->take(5)->get()
            : collect();

        return view('hidden-gem.index', compact('campuses', 'selectedCampus', 'restaurants'));
    }

    public function getRestaurants(int $campusId): JsonResponse
    {
        $campus = Campus::findOrFail($campusId);

        $restaurants = Restaurant::where('campus_id', $campusId)
            ->orderByDesc('rating')
            ->get()
            ->map(fn($r) => [
                'id'          => $r->id,
                'name'        => $r->name,
                'image'       => asset('assets/img/' . $r->image),
                'description' => $r->description,
                'latitude'    => $r->latitude,
                'longitude'   => $r->longitude,
                'rating'      => $r->rating,
                'distance'    => $r->distance,
                'price_range' => $r->price_range,
                'category'    => $r->category,
                'maps_url'    => "https://www.google.com/maps?q={$r->latitude},{$r->longitude}",
            ]);

        return response()->json([
            'campus'      => [
                'id'        => $campus->id,
                'name'      => $campus->name,
                'latitude'  => (float) $campus->latitude,
                'longitude' => (float) $campus->longitude,
                'zoom'      => $campus->map_zoom,
            ],
            'restaurants' => $restaurants,
        ]);
    }
}