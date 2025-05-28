<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hotel_id',
        'room_number',
        'room_type',
        'occupancy',
        'images',
        'price_per_night',
        'is_available',
        'description',
    ];

    protected $casts = [
        'images' => 'array',
        'is_available' => 'boolean',
        'price_per_night' => 'decimal:2',
    ];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_room');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
