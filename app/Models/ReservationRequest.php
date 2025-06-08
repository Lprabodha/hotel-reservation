<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationRequest extends Model
{
    protected $fillable = [
        'travel_company_id',
        'check_in_date',
        'check_out_date',
        'description',
        'hotel_id'
    ];

    public function travelCompany()
    {
        return $this->belongsTo(TravelCompany::class);
    }
}
