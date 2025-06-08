<?php
namespace Tests\Feature\Admin;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RoomControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Hotel $hotel;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
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
    }

    #[Test]
    public function it_can_access_rooms_index()
    {
        $response = $this->get(route('admin.rooms.index'));

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[Test]
    public function it_can_access_create_route()
    {
        $response = $this->get(route('admin.rooms.create'));

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[Test]
    public function it_can_access_store_route()
    {
        $roomData = [
            'hotel_id' => $this->hotel->id,
            'room_number' => '201',
            'room_type' => 'suite',
            'occupancy' => 4,
            'price_per_night' => 250.00,
            'is_available' => true,
            'description' => 'A luxurious suite room',
        ];

        $response = $this->post(route('admin.rooms.store'), $roomData);

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[Test]
    public function it_can_access_update_route()
    {
        $room = Room::create([
            'hotel_id' => $this->hotel->id,
            'room_number' => '501',
            'room_type' => 'single',
            'occupancy' => 2,
            'price_per_night' => 100.00,
            'is_available' => true,
            'description' => 'Original room description',
            'images' => [],
        ]);

        $updateData = [
            'hotel_id' => $this->hotel->id,
            'room_number' => '501-Updated',
            'room_type' => 'double',
            'occupancy' => 4,
            'price_per_night' => 300.00,
            'is_available' => false,
            'description' => 'Updated room description',
        ];

        $response = $this->patch(route('admin.rooms.update', $room), $updateData);

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[Test]
    public function it_handles_validation_errors()
    {
        $response = $this->post(route('admin.rooms.store'), [
            'hotel_id' => '',
            'room_number' => '',
        ]);

        $this->assertNotEquals(500, $response->getStatusCode());

        $this->assertContains($response->getStatusCode(), [302, 422]);
    }
}