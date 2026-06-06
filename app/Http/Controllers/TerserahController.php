<?php

namespace App\Http\Controllers;

use App\Models\Food;

class TerserahController extends Controller
{
    public function index()
    {
        return view('terserah.index');
    }

    public function random($category)
    {
        if (!in_array($category, ['makanan', 'minuman', 'dessert'])) {
            return response()->json([
                'message' => 'Kategori tidak valid'
            ], 400);
        }

        $food = Food::with('restaurant')
            ->where('category', $category)
            ->whereHas('restaurant', function ($query) {
                $query->approved();
            })
            ->inRandomOrder()
            ->first();

        if (!$food) {
            return response()->json([
                'message' => 'Belum ada data untuk kategori ini'
            ], 404);
        }

        return response()->json([
            'id' => $food->id,
            'name' => $food->name,
            'price' => $food->price,
            'category' => $food->category,
            'image' => asset($food->image),
            'restaurant' => [
                'name' => $food->restaurant->name,
                'address' => $food->restaurant->address,
                'image' => $food->restaurant->image
                    ? asset($food->restaurant->image)
                    : asset($food->image),
            ],
        ]);
    }
}
