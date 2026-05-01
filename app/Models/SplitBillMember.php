<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SplitBillMember extends Model
{
    //
    protected $fillable = ['split_bill_id', 'member_name', 'share_amount'];

    public function splitBill()
    {
        return $this->belongsTo(SplitBill::class);
    }
}
