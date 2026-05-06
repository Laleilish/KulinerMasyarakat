<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(["name", "email", "password"])]
#[Hidden(["password", "remember_token"])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        "name",
        "username",
        "email",
        "password",
        "role",
        "email_verified_at",
    ];

    protected $hidden = ["password", "remember_token"];

    protected $casts = [
        "email_verified_at" => "datetime",
    ];

    public function restaurant()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function submit_place()
    {
        return $this->hasMany(Submit_place::class);
    }

    public function splitBill()
    {
        return $this->hasMany(Submit_place::class);
    }

    // Helper cek role

    public function isAdmin()
    {
        return $this->role === "admin";
    }

    public function isOwner()
    {
        return $this->role === "owner";
    }
}
