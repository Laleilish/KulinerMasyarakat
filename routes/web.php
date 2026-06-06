<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmitPlaceController;
use App\Http\Controllers\Admin\SubmitPlaceController as AdminSubmitPlaceController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\HiddenGemController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::get("/dashboard", function () {
    return view("dashboard");
})
    ->middleware(["auth", "verified"])
    ->name("dashboard");

Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, "show"])->name(
        "profile.show",
    );
    Route::get("/profile/edit", [ProfileController::class, "edit"])->name(
        "profile.edit",
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update",
    );
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy",
    );

    // Review (butuh login)
    Route::post("/restoran/{restaurant}/reviews", [\App\Http\Controllers\ReviewController::class, "store"])->name(
        "reviews.store",
    );
    Route::delete("/reviews/{review}", [\App\Http\Controllers\ReviewController::class, "destroy"])->name(
        "reviews.destroy",
    );

    // Submit Places 
    Route::get("/submit-place", [SubmitPlaceController::class, "create"])->name(
        "submit-places.create",
    );
    Route::post("/submit-place", [SubmitPlaceController::class, "store"])->name(
        "submit-places.store",
    );

    // Notifications
    Route::get("/notifications/{id}/read", [\App\Http\Controllers\NotificationController::class, "read"])->name(
        "notifications.read",
    );
});

// Detail restoran 
Route::get("/restoran/{restaurant}", [\App\Http\Controllers\RestaurantController::class, "show"])->name("restoran.show");

// API: reviews untuk popup hidden gem (public, no auth required)
Route::get('/api/restoran/{restaurant}/reviews', function (\App\Models\Restaurant $restaurant) {
    $reviews = $restaurant->reviews()
        ->with('user:id,name')
        ->latest()
        ->take(5)
        ->get()
        ->map(fn($rv) => [
            'id'         => $rv->id,
            'user_name'  => $rv->user->name ?? 'Anonim',
            'rating'     => $rv->rating,
            'comment'    => $rv->comment,
            'created_at' => $rv->created_at->diffForHumans(),
        ]);
    return response()->json($reviews);
})->name('api.restoran.reviews');

// Admin Routes
Route::middleware(["auth", "role:admin"])
    ->prefix("admin")
    ->name("admin.")
    ->group(function () {
        // Dashboard
        Route::get("/", [AdminDashboardController::class, "index"])->name("dashboard");
        Route::get("/dashboard", [AdminDashboardController::class, "index"]);

        // Submit Places
        Route::get("/submit-places", [AdminSubmitPlaceController::class, "index"])->name(
            "submit-places.index",
        );
        Route::get("/submit-places/report", [AdminSubmitPlaceController::class, "report"])->name(
            "submit-places.report",
        );
        Route::get("/submit-places/{submitPlace}", [AdminSubmitPlaceController::class, "show"])->name(
            "submit-places.show",
        );
        Route::get("/submit-places/{submitPlace}/edit", [AdminSubmitPlaceController::class, "edit"])->name(
            "submit-places.edit",
        );
        Route::put("/submit-places/{submitPlace}", [AdminSubmitPlaceController::class, "update"])->name(
            "submit-places.update",
        );
        Route::delete("/submit-places/{submitPlace}", [AdminSubmitPlaceController::class, "destroy"])->name(
            "submit-places.destroy",
        );
        Route::patch("/submit-places/{submitPlace}/approve", [AdminSubmitPlaceController::class, "approve"])->name(
            "submit-places.approve",
        );
        Route::patch("/submit-places/{submitPlace}/reject", [AdminSubmitPlaceController::class, "reject"])->name(
            "submit-places.reject",
        );

        // Users
        Route::get("/users", [AdminUserController::class, "index"])->name("users.index");
        Route::patch("/users/{user}/toggle-role", [AdminUserController::class, "toggleRole"])->name("users.toggle-role");
        Route::delete("/users/{user}", [AdminUserController::class, "destroy"])->name("users.destroy");
    });

Route::get("/", [\App\Http\Controllers\HomeController::class, 'index'])->name("home");
Route::get('/hidden-gem', [HiddenGemController::class, 'index'])
    ->middleware('auth')
    ->name('hidden-gem.index');
Route::get('/hidden-gem/restaurants/{campusId}', [HiddenGemController::class, 'getRestaurants'])
    ->middleware('auth')
    ->name('hidden-gem.restaurants');
Route::get('/semua-resto', [RestaurantController::class, 'index'])->name('semua-resto');
Route::get('/tanggal-tua', [RestaurantController::class, 'tanggalTua'])->name('tanggal-tua.index');
Route::get('/terserah', fn() => view('terserah.index'))->name('terserah.index');
Route::get('/proposal', fn() => view('submit-place.create'))->name('submit-place.create');
Route::get('/split-bill', fn() => view('split-bill.index'))->name('split-bill.index');
Route::get("/terserah", fn() => view("terserah.index"))->name(
    "terserah.index"
);
Route::get("/split-bill", fn() => view("split-bill.index"))->name(
    "split-bill.index",
);

Route::get("/syarat-ketentuan", fn() => view("pages.terms"))->name("terms");
Route::get("/kebijakan-privasi", fn() => view("pages.privacy"))->name("privacy");



require __DIR__ . "/auth.php";
