<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OtpVerification extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "otp", "expires_at", "is_used"];

    protected $casts = [
        "expires_at" => "datetime",
        "is_used" => "boolean",
    ];

    /**
     * Relationship dengan User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Cek apakah OTP masih valid (belum expire & belum digunakan)
     */
    public function isValid(): bool
    {
        return !$this->is_used && $this->expires_at->isFuture();
    }

    /**
     * Tandai OTP sebagai sudah digunakan
     */
    public function markAsUsed(): void
    {
        $this->update(["is_used" => true]);
    }
}
