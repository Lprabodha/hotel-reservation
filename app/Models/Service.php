<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function bills()
    {
        return $this->belongsToMany(Bill::class, 'bill_service')->withPivot('charge')->withTimestamps();
    }
}
