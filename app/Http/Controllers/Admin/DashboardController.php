<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\SubmitPlace;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with stats and recent pending places.
     */
    public function index()
    {
        $stats = [
            'users_count' => User::count(),
            'restaurants_count' => Restaurant::count(),
            'pending_places_count' => SubmitPlace::pending()->count(),
            'reviews_count' => Review::count(),
        ];

        $recentPendingPlaces = SubmitPlace::with(['user', 'campus'])
            ->pending()
            ->latest()
            ->take(5)
            ->get();

        // Aktivitas terbaru
        $recentActivities = SubmitPlace::with('user')
            ->latest('updated_at')
            ->take(10)
            ->get()
            ->map(function ($place) {
                if ($place->status === 'approved') {
                    return [
                        'type' => 'approved',
                        'title' => $place->name . ' Approved',
                        'subtitle' => 'Disetujui • ' . $place->updated_at->diffForHumans(),
                    ];
                } elseif ($place->status === 'rejected') {
                    return [
                        'type' => 'rejected',
                        'title' => $place->name . ' Ditolak',
                        'subtitle' => 'Ditolak • ' . $place->updated_at->diffForHumans(),
                    ];
                } else {
                    return [
                        'type' => 'new',
                        'title' => 'New Submission: ' . $place->name,
                        'subtitle' => 'Submitted by ' . ($place->user->name ?? 'User') . ' • ' . $place->created_at->diffForHumans(),
                    ];
                }
            });

        // Data chart popularitas
        $chartData = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData->push([
                'label' => $date->translatedFormat('D'),
                'submissions' => SubmitPlace::whereDate('created_at', $date)->count(),
                'reviews' => Review::whereDate('created_at', $date)->count(),
            ]);
        }

        return view('admin.dashboard', compact('stats', 'recentPendingPlaces', 'recentActivities', 'chartData'));
    }
}
