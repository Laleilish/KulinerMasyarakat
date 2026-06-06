<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Services\CloudinaryService;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(Request $request): View
    {
        return view("profile.show", [
            "user" => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Handle avatar upload
        if ($request->hasFile("avatar")) {
            $request->validate([
                "avatar" => ["image", "max:2048"],
            ]);

            // Delete old avatar if it exists and is not from OAuth provider
            if ($user->avatar && !$user->provider) {
                // Remove /storage/ prefix if present for local deletion, though CloudinaryService handles URLs too
                $oldAvatarPath = str_replace("/storage/", "", $user->avatar);
                CloudinaryService::delete($oldAvatarPath);
                // Also try deleting the original avatar just in case it was a Cloudinary URL
                CloudinaryService::delete($user->avatar);
            }

            // Store new avatar
            $user->avatar = CloudinaryService::upload($request->file("avatar"), "avatars");
        }

        // Update other profile fields
        $user->fill($request->validated());

        if ($user->isDirty("email")) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route("profile.show")->with(
            "status",
            "profile-updated",
        );
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag("userDeletion", [
            "password" => ["required", "current_password"],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to("/");
    }
}
