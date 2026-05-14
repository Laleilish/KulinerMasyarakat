<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view("auth.register");
    }

    /**
     * Handle an incoming registration request.
     * Step 1: Create user and send OTP
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            "name" => ["required", "string", "max:255"],
            "username" => [
                "required",
                "string",
                "max:255",
                "unique:" . User::class,
                "alpha_dash", 
            ],
            "email" => [
                "required",
                "string",
                "lowercase",
                "email",
                "max:255",
                "unique:" . User::class,
            ],
            "password" => ["required", "confirmed", Rules\Password::defaults()],
        ]);

        // Buat user baru (belum verified)
        $user = User::create([
            "name" => $request->name,
            "username" => $request->username,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "email_verified_at" => null, // Belum verified
        ]);

        // Generate OTP (4 digit)
        $otp = str_pad(random_int(0, 9999), 4, "0", STR_PAD_LEFT);

        // Hapus OTP lama
        OtpVerification::where("user_id", $user->id)
            ->where("is_used", false)
            ->delete();

        // Simpan OTP baru (expire 10 menit untuk register)
        OtpVerification::create([
            "user_id" => $user->id,
            "otp" => $otp,
            "expires_at" => now()->addMinutes(10),
        ]);

        // Kirim OTP via email
        Mail::to($user->email)->send(new OtpMail($otp, $user->name));

        // Trigger event registered
        event(new Registered($user));

        // Simpan user_id di session untuk verifikasi
        $request->session()->put("register_user_id", $user->id);

        return redirect()->route("register.otp.verify");
    }

    /**
     * Show OTP verification form (after registration)
     */
    public function showOtpVerification(): View|RedirectResponse
    {
        // Pastikan user sudah register
        if (!session("register_user_id")) {
            return redirect()->route("register");
        }

        $user = User::find(session("register_user_id"));

        return view("auth.register-verify-otp", [
            "email" => $user->email,
            "name" => $user->name,
        ]);
    }

    /**
     * Verify OTP and activate account
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            "otp" => "required|string|size:4",
        ]);

        $userId = session("register_user_id");

        if (!$userId) {
            return redirect()
                ->route("register")
                ->withErrors([
                    "otp" => "Sesi telah berakhir. Silakan daftar kembali.",
                ]);
        }

        // Cari OTP yang valid
        $otpRecord = OtpVerification::where("user_id", $userId)
            ->where("otp", $request->otp)
            ->where("is_used", false)
            ->where("expires_at", ">", now())
            ->first();

        if (!$otpRecord) {
            throw ValidationException::withMessages([
                "otp" => __(
                    "Kode OTP salah atau sudah kadaluarsa. Silakan kirim ulang.",
                ),
            ]);
        }

        // Tandai OTP sebagai sudah digunakan
        $otpRecord->markAsUsed();

        // Verifikasi email user
        $user = User::find($userId);
        $user->email_verified_at = now();
        $user->save();

        // Login user
        Auth::login($user);

        // Regenerate session
        $request->session()->regenerate();

        // Clear session data
        $request->session()->forget("register_user_id");

        return redirect()
            ->route("home")
            ->with("status", "Akun berhasil diverifikasi! Selamat datang.");
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request): RedirectResponse
    {
        $userId = session("register_user_id");

        if (!$userId) {
            return redirect()->route("register");
        }

        $user = User::find($userId);

        // Generate OTP baru (4 digit)
        $otp = str_pad(random_int(0, 9999), 4, "0", STR_PAD_LEFT);

        // Hapus OTP lama
        OtpVerification::where("user_id", $user->id)
            ->where("is_used", false)
            ->delete();

        // Simpan OTP baru
        OtpVerification::create([
            "user_id" => $user->id,
            "otp" => $otp,
            "expires_at" => now()->addMinutes(10),
        ]);

        // Kirim email
        Mail::to($user->email)->send(new OtpMail($otp, $user->name));

        return back()->with(
            "status",
            "Kode OTP baru telah dikirim ke email Anda.",
        );
    }
}
