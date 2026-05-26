<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use Illuminate\View\View;

class HiddenGemController extends Controller
{
    public function index(): View
    {
        $campuses = Campus::all();

        $campusesData = $campuses->map(fn($c) => [
            'id'        => $c->id,
            'name'      => $c->name,
            'logo'      => asset('assets/img/kampus/' . $c->logo),
            'latitude'  => (float) $c->latitude,
            'longitude' => (float) $c->longitude,
            'zoom'      => $c->map_zoom,
        ])->values();

        $selectedCampus = $campuses->first();

        return view('hidden-gem.index', compact('campusesData', 'selectedCampus', 'campuses'));
    }

    public function getRestaurants(int $campusId): \Illuminate\Http\JsonResponse
    {
        $campus = Campus::findOrFail($campusId);

        $restaurants = $campus->restaurants()
            ->orderByDesc('rating')
            ->get()
            ->map(fn($r) => [
                'id'          => $r->id,
                'name'        => $r->name,
                'image'       => asset('assets/img/' . $r->image),
                'description' => $r->description,
                'latitude'    => (float) $r->latitude,
                'longitude'   => (float) $r->longitude,
                'rating'      => $r->rating,
                'distance'    => $r->distance,
                'price_range' => $r->price_range,
                'category'    => $r->category,
            ]);

        return response()->json([
            'campus' => [
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