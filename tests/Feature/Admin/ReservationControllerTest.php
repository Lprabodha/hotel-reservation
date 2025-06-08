<?php

namespace Tests\Feature\Admin;

use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Hotel $hotel;
    protected Room $room;

    protected function setUp(): void
    {
        parent::setUp();
        
        Role::create(['name' => 'hotel-clerk']);
        Role::create(['name' => 'super-admin']);
        
        $this->user = User::factory()->create();
        $this->user->assignRole('hotel-clerk');
        $this->actingAs($this->user);
        
        $this->hotel = Hotel::create([
            'name' => 'Test Hotel',
            'slug' => 'test-hotel',
            'location' => 'Test City',
            'phone' => '+1234567890',
            'type' => 'luxury',
            'email' => 'test@hotel.com',
            'address' => '123 Test Street',
            'country' => 'Test Country',
            'active' => true,
        ]);
        
        $this->user->hotels()->attach($this->hotel->id);
        
        $this->room = Room::create([
            'hotel_id' => $this->hotel->id,
            'room_number' => '101',
            'room_type' => 'double',
            'occupancy' => 2,
            'is_available' => true,
            'price_per_night' => 100.00,
        ]);
        
        \DB::table('room_rates')->insert([
            'room_id' => $this->room->id,
            'rate_type' => 'daily',
            'amount' => 100.00,
        ]);
    }

    #[Test]
    public function it_can_display_reservations_index()
    {
        $response = $this->get(route('admin.reservation.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function it_can_access_create_reservation_page()
    {
        $response = $this->get(route('admin.reservation.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.reservations.create');
        $response->assertViewHas(['hotel', 'rooms', 'bookedDates']);
    }

    #[Test]
    public function it_can_access_store_route()
    {
        $customer = User::factory()->create([
            'email' => 'customer@test.com'
        ]);

        $reservationData = [
            'customer_type' => 'individual',
            'customer_email' => $customer->id,
            'checkin' => Carbon::tomorrow()->format('Y-m-d'),
            'checkout' => Carbon::tomorrow()->addDays(2)->format('Y-m-d'),
            'rooms' => [$this->room->id],
            'guests' => 2,
            'special_requests' => 'Test request',
        ];

        $response = $this->post(route('admin.reservation.store'), $reservationData);

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[Test]
    public function it_can_access_reservation_view()
    {
        $customer = User::factory()->create([
            'email' => 'customer@test.com'
        ]);

        $reservation = Reservation::create([
            'user_id' => $customer->id,
            'hotel_id' => $this->hotel->id,
            'check_in_date' => Carbon::tomorrow()->format('Y-m-d'),
            'check_out_date' => Carbon::tomorrow()->addDays(2)->format('Y-m-d'),
            'status' => 'booked',
            'number_of_guests' => 2,
            'total_price' => 200.00,
            'discount_rate' => 0,
            'payment_status' => 'pending',
            'payment_method' => 'none',
            'confirmation_number' => 'TEST123456',
        ]);

        $reservation->rooms()->attach($this->room->id);

        $response = $this->get(route('admin.reservation.view', ['id' => $reservation->confirmation_number]));

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[Test]
    public function it_can_change_reservation_status()
    {
        $customer = User::factory()->create([
            'email' => 'customer@test.com'
        ]);

        $reservation = Reservation::create([
            'user_id' => $customer->id,
            'hotel_id' => $this->hotel->id,
            'check_in_date' => Carbon::tomorrow()->format('Y-m-d'),
            'check_out_date' => Carbon::tomorrow()->addDays(2)->format('Y-m-d'),
            'status' => 'booked',
            'number_of_guests' => 2,
            'total_price' => 200.00,
            'discount_rate' => 0,
            'payment_status' => 'pending',
            'payment_method' => 'none',
            'confirmation_number' => 'TEST123456',
        ]);

        $response = $this->post(route('admin.reservation.changeStatus', $reservation->id), [
            'status' => 'checked_in'
        ]);

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }
}
