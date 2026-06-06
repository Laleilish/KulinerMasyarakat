<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Store a newly created review.
     */
    public function store(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'comment'  => 'nullable|string|max:1000',
            'photos'   => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Check if user already reviewed this restaurant
        $existingReview = Review::where('user_id', Auth::id())
            ->where('restaurant_id', $restaurant->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()
                ->with('error', 'Kamu sudah pernah memberikan ulasan untuk restoran ini.');
        }

        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $photoPaths[] = $file->store('reviews', 'public');
            }
        }

        Review::create([
            'user_id'       => Auth::id(),
            'restaurant_id' => $restaurant->id,
            'rating'        => $validated['rating'],
            'comment'       => $validated['comment'] ?? null,
            'photos'        => !empty($photoPaths) ? $photoPaths : null,
        ]);

        return redirect()->back()
            ->with('success', 'Ulasan berhasil ditambahkan!');
    }

    /**
     * Remove the specified review.
     */
    public function destroy(Review $review)
    {
        // Only the review owner or an admin can delete
        if (Auth::id() !== $review->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus ulasan ini.');
        }

        // Delete photos from storage if exists
        if ($review->photos) {
            foreach ($review->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $review->delete();

        return redirect()->back()
            ->with('success', 'Ulasan berhasil dihapus.');
    }
}
