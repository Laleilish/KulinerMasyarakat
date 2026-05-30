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

        // Data chart aktivitas platform
        $range = request('range', '7d');
        $chartData = $this->getChartData($range);

        return view('admin.dashboard', compact('stats', 'recentPendingPlaces', 'recentActivities', 'chartData', 'range'));
    }

    /**
     * Generate chart data based on the selected range.
     */
    private function getChartData(string $range)
    {
        $chartData = collect();

        switch ($range) {
            case '1m':
                // 30 hari terakhir, per hari
                for ($i = 29; $i >= 0; $i--) {
                    $date = Carbon::today()->subDays($i);
                    $chartData->push([
                        'label' => $date->format('d/m'),
                        'restaurants' => Restaurant::whereDate('created_at', $date)->count(),
                        'reviews' => Review::whereDate('created_at', $date)->count(),
                    ]);
                }
                break;

            case '1y':
                // 12 bulan terakhir, per bulan
                for ($i = 11; $i >= 0; $i--) {
                    $date = Carbon::today()->subMonths($i);
                    $startOfMonth = $date->copy()->startOfMonth();
                    $endOfMonth = $date->copy()->endOfMonth();
                    $chartData->push([
                        'label' => $date->translatedFormat('M'),
                        'restaurants' => Restaurant::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
                        'reviews' => Review::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
                    ]);
                }
                break;

            default: // 7d
                for ($i = 6; $i >= 0; $i--) {
                    $date = Carbon::today()->subDays($i);
                    $chartData->push([
                        'label' => $date->translatedFormat('D'),
                        'restaurants' => Restaurant::whereDate('created_at', $date)->count(),
                        'reviews' => Review::whereDate('created_at', $date)->count(),
                    ]);
                }
                break;
        }

        return $chartData;
    }
}
