<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the OAuth Provider authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider(string $provider)
    {
        try {
            return Socialite::driver($provider)->redirect();
        } catch (Exception $e) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'error' => 'Unable to connect to '.
                        ucfirst($provider).
                        '. Please try again.',
                ]);
        }
    }

    /**
     * Obtain the user information from the OAuth Provider.
     */
    public function handleProviderCallback(string $provider): RedirectResponse
    {
        try {
            // Get user info from the provider
            $providerUser = Socialite::driver($provider)->user();

            // Check if user exists by provider and provider_id
            $user = User::where('provider', $provider)
                ->where('provider_id', $providerUser->getId())
                ->first();

            // If not found by provider, check by email
            if (! $user) {
                $user = User::where(
                    'email',
                    $providerUser->getEmail(),
                )->first();
            }

            if ($user) {
                // Update existing user information
                // Preserve custom avatar if user has uploaded one (Cloudinary URL)
                $avatarValue = $user->avatar;
                if (!$user->avatar || !str_contains($user->avatar, 'cloudinary')) {
                    $avatarValue = $providerUser->getAvatar();
                }

                $user->update([
                    'name' => $providerUser->getName() ?? $user->name,
                    'email' => $providerUser->getEmail() ?? $user->email,
                    'provider' => $provider,
                    'provider_id' => $providerUser->getId(),
                    'avatar' => $avatarValue,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);
            } else {
                // Create new user
                $username = $this->generateUsername($providerUser->getEmail());

                $user = User::create([
                    'name' => $providerUser->getName(),
                    'email' => $providerUser->getEmail(),
                    'provider' => $provider,
                    'provider_id' => $providerUser->getId(),
                    'avatar' => $providerUser->getAvatar(),
                    'email_verified_at' => now(),
                    'username' => $username,
                    'password' => null,
                    'role' => 'user',
                ]);
            }

            // Login the user
            Auth::login($user);

            // Regenerate session for security
            request()->session()->regenerate();

            // Redirect to appropriate route based on role
            $redirectRoute = $user->isAdmin() ? 'admin.dashboard' : 'home';
            
            return redirect()
                ->route($redirectRoute)
                ->with(
                    'status',
                    'Successfully logged in with '.ucfirst($provider).'!',
                );
        } catch (Exception $e) {
            // Log the error for debugging
            Log::error('Socialite callback error: '.$e->getMessage());

            return redirect()
                ->route('login')
                ->withErrors([
                    'error' => 'Unable to login with '.
                        ucfirst($provider).
                        '. Please try again or use another method.',
                ]);
        }
    }

    /**
     * Generate a unique username from email
     */
    private function generateUsername(string $email): string
    {
        $baseUsername = Str::before($email, '@');
        $baseUsername = preg_replace('/[^a-zA-Z0-9_-]/', '', $baseUsername);

        // Ensure username is unique
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername.$counter;
            $counter++;
        }

        return $username;
    }
}
