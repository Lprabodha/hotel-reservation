<?php

namespace App\Models;

use App\Enums\HotelType;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'location',
        'phone',
        'type',
        'email',
        'star_rating',
        'description',
        'address',
        'country',
        'website',
        'images',
        'active'
    ];

    protected $casts = [
        'type' => HotelType::class,
        'active' => 'boolean',
        'star_rating' => 'integer',
        'images' => 'array'
    ];
    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
