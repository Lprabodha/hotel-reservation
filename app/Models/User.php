<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'provider',
        'provider_id',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class);
    }

    public function getRoleName()
    {
        return $this->roles->pluck('name')->first() ?? 'No Role';
    }

    public function assignedHotels()
    {
        if ($this->hasRole(['hotel manager', 'hotel clerk'])) {
            return $this->hotels;
        }

        return collect([]);
    }

    public function createSuperAdmin(array $details): self
    {
        $user = User::create([
            'name' => $details['name'],
            'email' => $details['email'],
            'password' => $details['password'],
        ]);

        return $user->assignRole('super-admin');
    }

    public function getRolesColorAttribute()
    {
        return [
            'super-admin' => 'success',
            'travel-company' => 'info',
            'customer' => 'success',
            'hotel-manager' => 'warning',
            'hotel-clerk' => 'warning',
        ][$this->roles[0]->name] ?? 'dark';
    }

    public function travelCompany()
    {
        return $this->hasOne(TravelCompany::class);
    }
}
