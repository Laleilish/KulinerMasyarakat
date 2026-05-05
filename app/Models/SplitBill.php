<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SplitBill extends Model
{
    //
    protected $fillable = ['user_id', 'title', 'total_amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->hasMany(SplitBillMember::class);
    }
}
