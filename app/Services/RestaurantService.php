<?php

namespace App\Services;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Collection;

class RestaurantService
{
    public function getDetail(Restaurant $restaurant): Restaurant
    {
        $restaurant->load([
            'user',
            'campus',
            'reviews.user'
        ]);

        return $restaurant;
    }

    public function getRelated(Restaurant $restaurant, int $limit = 5): Collection
    {
        return Restaurant::approved()
            ->where('id', '!=', $restaurant->id)
            ->where('campus_id', $restaurant->campus_id)
            ->withCount('reviews')
            ->orderByDesc('reviews_count')
            ->limit($limit)
            ->get();
    }
}