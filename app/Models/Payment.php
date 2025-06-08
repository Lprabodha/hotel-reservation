<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'bill_id',
        'method',
        'amount',
        'paid_at',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
