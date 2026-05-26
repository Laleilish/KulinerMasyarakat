<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    //

    protected $fillable = ['name', 'latitude', 'longitude'];

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function submitPlaces()
    {
        return $this->hasMany(SubmitPlace::class);
    }
}
