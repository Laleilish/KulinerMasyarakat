<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campus extends Model
{
    protected $fillable = ['name', 'logo', 'latitude', 'longitude', 'map_zoom'];

    protected $fillable = ['name', 'logo', 'latitude', 'longitude', 'map_zoom'];

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function submitPlaces()
    {
        return $this->hasMany(SubmitPlace::class);
    }
}