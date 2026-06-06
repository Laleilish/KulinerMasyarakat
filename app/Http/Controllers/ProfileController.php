<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
                
                // Check if file exists in storage
                $oldAvatarPath = str_replace("/storage/", "", $user->avatar);
                if (Storage::disk("public")->exists($oldAvatarPath)) {
                    Storage::disk("public")->delete($oldAvatarPath);
                }
            }

            // Store new avatar
            $avatarPath = $request->file("avatar")->store("avatars", "public");
            $user->avatar = "/storage/" . $avatarPath;
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
