<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OtpVerification;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view("auth.login");
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $user = $request->user();

        // 24H verified
        if (!$user->email_verified_at && $user->created_at->lt(now()->subDay())) {
            Auth::guard("web")->logout();

            OtpVerification::where("user_id", $user->id)->delete();

            $user->delete();

            throw ValidationException::withMessages([
                "email" => "Pendaftaran sudah kadaluarsa. Silakan daftar ulang.",
            ]);
        }
        
        //Validate verified email 
        if (!$user->email_verified_at) {
            Auth::guard("web")->logout();
            session(["register_user_id" => $user->id]);

            return redirect()
                ->route("register.otp.verify")
                ->with("status", "Akun belum diverifikasi. Silakan masukkan OTP.");
        }

        $request->session()->regenerate();

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false))
                ->with('status', 'Berhasil masuk.');
        }

        return redirect()->intended(route("home", absolute: false))
            ->with('status', 'Berhasil masuk.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard("web")->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect("/");
    }
}
