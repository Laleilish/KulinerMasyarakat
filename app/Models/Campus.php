<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campus extends Model
{
    protected $fillable = ['name', 'logo', 'latitude', 'longitude', 'map_zoom'];

    public function restaurants(): HasMany
    {
        return $this->hasMany(Restaurant::class);
    }
}