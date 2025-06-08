<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'reservation_id',
        'room_charges',
        'extra_charges',
        'discount',
        'taxes',
        'total_amount',
        'status',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'bill_service', 'bill_id', 'service_id')
            ->withPivot('charge');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
