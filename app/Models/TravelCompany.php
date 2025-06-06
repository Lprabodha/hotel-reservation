<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelCompany extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_name',
        'email',
        'contact_number',
        'address',
        'discount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
