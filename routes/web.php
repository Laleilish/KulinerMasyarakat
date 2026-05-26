<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmitPlaceController;
use App\Http\Controllers\Admin\SubmitPlaceController as AdminSubmitPlaceController;
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
});

// Detail restoran 
Route::get("/restoran/{restaurant}", [\App\Http\Controllers\RestaurantController::class, "show"])->name("restoran.show");

// Admin Routes
Route::middleware(["auth", "role:admin"])
    ->prefix("admin")
    ->name("admin.")
    ->group(function () {
        Route::get("/submit-places", [AdminSubmitPlaceController::class, "index"])->name(
            "submit-places.index",
        );
        Route::get("/submit-places/{submitPlace}", [AdminSubmitPlaceController::class, "show"])->name(
            "submit-places.show",
        );
        Route::patch("/submit-places/{submitPlace}/approve", [AdminSubmitPlaceController::class, "approve"])->name(
            "submit-places.approve",
        );
        Route::patch("/submit-places/{submitPlace}/reject", [AdminSubmitPlaceController::class, "reject"])->name(
            "submit-places.reject",
        );
    });

Route::get("/", [\App\Http\Controllers\HomeController::class, 'index'])->name("home");
Route::get("/hidden-gem", fn() => view("hidden-gem.index"))->name(
    "hidden-gem.index",
);
Route::get("/tanggal-tua", fn() => view("tanggal-tua.index"))->name(
    "tanggal-tua.index",
);
Route::get("/terserah", fn() => view("terserah.index"))->name(
    "terserah.index"
);
Route::get("/split-bill", fn() => view("split-bill.index"))->name(
    "split-bill.index",
);


require __DIR__ . "/auth.php";
