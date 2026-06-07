<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Restaurant;

class TerserahController extends Controller
{
    private array $validCategories = ['makanan', 'minuman', 'jajanan'];

    private array $dbCategoryMap = [
        'makanan' => 'makanan_berat',
        'minuman' => 'minuman',
        'jajanan' => 'jajanan',
    ];

    public function index()
    {
        return view('terserah.index');
    }

    /**
     * Ambil 1 makanan/minuman/dessert secara acak dari kategori tertentu,
     * sekaligus kembalikan daftar restoran yang punya menu di kategori tersebut.
     */
    public function random($category)
    {
        if (!in_array($category, $this->validCategories)) {
            return response()->json([
                'message' => 'Kategori tidak valid'
            ], 400);
        }

        $dbCategory = $this->dbCategoryMap[$category];

        // Ambil 1 restoran secara random dari kategori yang dipilih untuk mendapatkan food_type
        $randomRestaurant = Restaurant::approved()
            ->where('category', $dbCategory)
            ->inRandomOrder()
            ->first();

        if (!$randomRestaurant) {
            return response()->json([
                'message' => 'Belum ada data untuk kategori ini'
            ], 404);
        }

        // Ambil daftar restoran yang punya food_type ini
        $restaurants = Restaurant::approved()
            ->where('category', $dbCategory)
            ->where('food_type', $randomRestaurant->food_type)
            ->inRandomOrder()
            ->limit(5)
            ->get()
            ->map(function ($restaurant) {
                return [
                    'id'      => $restaurant->id,
                    'name'    => $restaurant->name,
                    'address' => $restaurant->address,
                    'image'   => $restaurant->image
                        ? (str_starts_with($restaurant->image, 'http') ? $restaurant->image : asset('storage/' . $restaurant->image))
                        : asset('assets/img/terserah/makanan.png'),
                    'url'     => route('restoran.show', $restaurant->id),
                ];
            });

        // Label kategori yang lebih ramah
        $categoryLabels = [
            'makanan' => 'Makanan Berat',
            'minuman' => 'Minuman',
            'jajanan' => 'Jajanan',
        ];

        return response()->json([
            'id'             => $randomRestaurant->id,
            'name'           => $randomRestaurant->food_type ?: $randomRestaurant->name,
            'category'       => $category,
            'category_label' => $categoryLabels[$category] ?? $category,
            'image'          => $randomRestaurant->image
                ? (str_starts_with($randomRestaurant->image, 'http') ? $randomRestaurant->image : asset('storage/' . $randomRestaurant->image))
                : asset('assets/img/terserah/' . ($category === 'jajanan' ? 'dessert' : $category) . '.png'),
            'restaurants'    => $restaurants,
        ]);
    }

    /**
     * Ambil beberapa gambar acak dari kategori untuk animasi loading cycling.
     */
    public function loadingImages($category)
    {
        if (!in_array($category, $this->validCategories)) {
            return response()->json(['images' => []], 400);
        }

        $dbCategory = $this->dbCategoryMap[$category];

        $images = Restaurant::approved()
            ->where('category', $dbCategory)
            ->whereNotNull('image')
            ->inRandomOrder()
            ->limit(6)
            ->pluck('image')
            ->map(fn($img) => str_starts_with($img, 'http') ? $img : asset('storage/' . $img))
            ->values();

        return response()->json(['images' => $images]);
    }
}
