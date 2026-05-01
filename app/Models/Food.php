<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    //
    protected $fillable = ['restaurant_id', 'name', 'price', 'category', 'image'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // Scope fitur Tanggal Tua (harga < 15000)
    public function scopeTanggalTua($query)
    {
        return $query->where('price', '<', 15000);
    }

    // Scope fitur Terserah (random by kategori)
    public function scopeRandom($query, $category = null)
    {
        if ($category) {
            $query->where('category', $category);
        }
        return $query->inRandomOrder()->limit(1);
    }
}
