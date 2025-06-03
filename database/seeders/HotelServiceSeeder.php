<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            'Room Service',
            'Housekeeping',
            'Laundry',
            'Airport Shuttle',
            'Concierge',
            'Spa',
            'Fitness Center',
            'Swimming Pool',
            'Free Wi-Fi',
            'Parking',
            'Restaurant',
            'Bar',
            'Business Center',
            'Wake-Up Call',
            'Babysitting',
            'Pet-Friendly',
        ];

        foreach ($services as $service) {
            Service::insert([
                'name' => $service,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
