<?php

namespace Tests\Feature\Admin;

use App\Models\Bill;
use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ReportControllerTest extends TestCase
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
    }

    #[Test]
    public function it_can_display_reports_index()
    {
        $response = $this->get(route('admin.reports.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.reports.index');
        $response->assertViewHas([
            'reservations',
            'occupiedRooms',
            'totalRooms',
            'occupancyRate',
            'futureDate',
            'futureOccupiedRooms',
            'futureOccupancyRate',
            'roomRevenue',
            'extraRevenue',
            'bills'
        ]);
    }

    #[Test]
    public function it_can_display_payments_page()
    {
        $response = $this->get(route('admin.reports.payments'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.reports.payments');
    }

    #[Test]
    public function it_can_access_bill_report_endpoint()
    {
        $customer = User::factory()->create();
        $reservation = Reservation::create([
            'user_id' => $customer->id,
            'hotel_id' => $this->hotel->id,
            'check_in_date' => Carbon::today()->format('Y-m-d'),
            'check_out_date' => Carbon::tomorrow()->format('Y-m-d'),
            'status' => 'booked',
            'number_of_guests' => 2,
            'total_price' => 200.00,
            'payment_status' => 'pending',
            'confirmation_number' => 'TEST123456',
        ]);

        Bill::create([
            'reservation_id' => $reservation->id,
            'room_charges' => 200.00,
            'extra_charges' => 50.00,
            'discount' => 0.00,
            'total_amount' => 250.00,
            'status' => 'unpaid',
        ]);

        $response = $this->post(route('admin.reports.bill'), [
            'draw' => 1,
            'start' => 0,
            'length' => 10,
            'order' => [['column' => 0, 'dir' => 'asc']],
            'search' => ['value' => '']
        ]);

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[Test]
    public function it_can_access_latest_reservation_report()
    {
        $customer = User::factory()->create();
        Reservation::create([
            'user_id' => $customer->id,
            'hotel_id' => $this->hotel->id,
            'check_in_date' => Carbon::tomorrow()->format('Y-m-d'),
            'check_out_date' => Carbon::tomorrow()->addDays(2)->format('Y-m-d'),
            'status' => 'booked',
            'number_of_guests' => 2,
            'total_price' => 200.00,
            'payment_status' => 'pending',
            'confirmation_number' => 'FUTURE123',
        ]);

        $response = $this->post(route('admin.reports.latest-reservation'), [
            'draw' => 1,
            'start' => 0,
            'length' => 10,
            'order' => [['column' => 0, 'dir' => 'asc']],
            'search' => ['value' => '']
        ]);

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[Test]
    public function it_can_access_past_reservation_report()
    {
        $customer = User::factory()->create();
        Reservation::create([
            'user_id' => $customer->id,
            'hotel_id' => $this->hotel->id,
            'check_in_date' => Carbon::yesterday()->format('Y-m-d'),
            'check_out_date' => Carbon::today()->format('Y-m-d'),
            'status' => 'completed',
            'number_of_guests' => 2,
            'total_price' => 200.00,
            'payment_status' => 'paid',
            'confirmation_number' => 'PAST123',
        ]);

        $response = $this->post(route('admin.reports.past-reservation'), [
            'draw' => 1,
            'start' => 0,
            'length' => 10,
            'order' => [['column' => 0, 'dir' => 'asc']],
            'search' => ['value' => '']
        ]);

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }
}