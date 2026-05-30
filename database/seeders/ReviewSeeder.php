<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Restaurant;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $restaurants = Restaurant::all();

        if ($users->isEmpty() || $restaurants->isEmpty()) {
            return;
        }

        $reviews = [
            [
                'comment' => 'Ayam gepreknya juara banget! Sambalnya nagih, pas buat dompet mahasiswa.',
                'rating' => 5,
            ],
            [
                'comment' => 'Porsinya banyak, tapi antrenya lumayan panjang kalau jam makan siang.',
                'rating' => 4,
            ],
            [
                'comment' => 'Rasanya enak sekali, bumbu meresap sempurna. Recommended!',
                'rating' => 5,
            ],
            [
                'comment' => 'Tempatnya lumayan nyaman, cocok buat kerja kelompok sambil ngopi santai.',
                'rating' => 4,
            ],
            [
                'comment' => 'Harganya sangat bersahabat bagi kantong kosan, rasa mantap.',
                'rating' => 5,
            ],
        ];

        foreach ($restaurants as $restaurant) {
            // Berikan 2 review acak untuk setiap restoran
            foreach ($users as $index => $user) {
                $reviewData = $reviews[($restaurant->id + $index) % count($reviews)];
                Review::create([
                    'user_id' => $user->id,
                    'restaurant_id' => $restaurant->id,
                    'rating' => $reviewData['rating'],
                    'comment' => $reviewData['comment'],
                    'photos' => null,
                ]);
            }
        }
    }
}
