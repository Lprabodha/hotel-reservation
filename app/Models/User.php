<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

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
}
