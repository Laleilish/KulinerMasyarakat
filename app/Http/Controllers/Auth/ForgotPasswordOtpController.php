<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordOtpMail;
use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ForgotPasswordOtpController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view("auth.forgot-password");
    }

    /**
     * Handle an incoming password reset link request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            "login" => "required|string",
        ]);

        $login = $request->login;

        // Cari user berdasarkan email atau username
        $user = User::where("email", $login)
            ->orWhere("username", $login)
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                "login" => __("Akun dengan email atau username tersebut tidak ditemukan."),
            ]);
        }

        // Generate OTP (4 digit)
        $otp = str_pad((string)random_int(0, 9999), 4, "0", STR_PAD_LEFT);

        // Hapus OTP lama yang belum terpakai untuk user ini
        OtpVerification::where("user_id", $user->id)
            ->where("is_used", false)
            ->delete();

        // Simpan OTP baru (expire 5 menit)
        OtpVerification::create([
            "user_id" => $user->id,
            "otp" => Hash::make($otp),
            "expires_at" => now()->addMinutes(5),
        ]);

        // Kirim OTP via email
        Mail::to($user->email)->send(new ResetPasswordOtpMail($otp, $user->name));

        // Simpan user_id di session untuk tahap verifikasi
        $request->session()->put("reset_user_id", $user->id);

        return redirect()->route("password.otp.verify")->with(
            "status", 
            "Kode OTP telah dikirim ke email Anda."
        );
    }

    /**
     * Show OTP verification form for password reset.
     */
    public function showOtpVerification(Request $request): View|RedirectResponse
    {
        $userId = session("reset_user_id");

        if (!$userId) {
            return redirect()->route("password.request");
        }

        $user = User::find($userId);

        if (!$user) {
            session()->forget("reset_user_id");
            return redirect()->route("password.request");
        }

        return view("auth.verify-reset-otp", [
            "email" => $user->email,
            "name" => $user->name,
        ]);
    }

    /**
     * Verify OTP and allow password reset.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            "otp" => "required|string|size:4",
        ]);

        $userId = session("reset_user_id");

        if (!$userId) {
            return redirect()->route("password.request")->withErrors([
                "login" => "Sesi telah berakhir. Silakan ulangi proses lupa kata sandi.",
            ]);
        }

        // Cari OTP yang valid
        $otpRecord = OtpVerification::where("user_id", $userId)
            ->where("is_used", false)
            ->where("expires_at", ">", now())
            ->first();

        if (!$otpRecord || !Hash::check($request->otp, $otpRecord->otp)) {
            throw ValidationException::withMessages([
                "otp" => __("Kode OTP salah atau sudah kadaluarsa. Silakan kirim ulang."),
            ]);
        }

        $otpRecord->markAsUsed();

        // Tandai di session bahwa OTP sukses diverifikasi
        $request->session()->put("reset_otp_verified", true);

        return redirect()->route("password.reset.form");
    }

    /**
     * Resend OTP for password reset.
     */
    public function resendOtp(Request $request): RedirectResponse
    {
        $userId = session("reset_user_id");

        if (!$userId) {
            return redirect()->route("password.request");
        }

        $user = User::find($userId);

        if (!$user) {
            session()->forget("reset_user_id");
            return redirect()->route("password.request");
        }

        // Generate OTP baru (4 digit)
        $otp = str_pad((string)random_int(0, 9999), 4, "0", STR_PAD_LEFT);

        // Hapus OTP lama
        OtpVerification::where("user_id", $user->id)
            ->where("is_used", false)
            ->delete();

        // Simpan OTP baru
        OtpVerification::create([
            "user_id" => $user->id,
            "otp" => Hash::make($otp),
            "expires_at" => now()->addMinutes(5),
        ]);

        // Kirim email
        Mail::to($user->email)->send(new ResetPasswordOtpMail($otp, $user->name));

        return back()->with(
            "status",
            "Kode OTP baru telah dikirim ke email Anda."
        );
    }

    /**
     * Display the new password reset view.
     */
    public function showResetForm(Request $request): View|RedirectResponse
    {
        if (!session("reset_otp_verified") || !session("reset_user_id")) {
            return redirect()->route("password.request");
        }

        return view("auth.reset-password");
    }

    /**
     * Handle an incoming new password request.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        if (!session("reset_otp_verified") || !session("reset_user_id")) {
            return redirect()->route("password.request");
        }

        $request->validate([
            "password" => ["required", "confirmed", Rules\Password::defaults()],
        ]);

        $user = User::find(session("reset_user_id"));

        if (!$user) {
            session()->forget(["reset_user_id", "reset_otp_verified"]);
            return redirect()->route("password.request");
        }

        // Update password
        $user->forceFill([
            "password" => Hash::make($request->password)
        ])->save();

        // Bersihkan session
        $request->session()->forget(["reset_user_id", "reset_otp_verified"]);

        return redirect()->route("login")->with(
            "status", 
            "Kata sandi Anda berhasil diubah. Silakan masuk dengan kata sandi baru."
        );
    }
}
