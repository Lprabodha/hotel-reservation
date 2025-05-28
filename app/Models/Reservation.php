<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes;

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'reservation_room');
    }
}
