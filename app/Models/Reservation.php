<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'check_in_date',
        'check_out_date',
        'status',
        'number_of_guests',
        'special_requests',
        'cancellation_reason',
        'cancellation_date',
        'total_price',
        'discount_rate',
        'payment_status',
        'payment_method',
        'confirmation_number',
        'note',
        'auto_cancelled',
        'no_show_billed',
        'hotel_id',
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'reservation_room');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
