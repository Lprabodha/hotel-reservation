<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_room');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
