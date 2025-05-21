<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'bill_service')->withPivot('charge')->withTimestamps();
    }
}
