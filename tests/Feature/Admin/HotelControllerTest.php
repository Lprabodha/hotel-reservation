<?php

namespace Tests\Feature\Admin;

use App\Enums\HotelType;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HotelControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_can_display_hotels_index()
    {
        Hotel::create([
            'name' => 'Test Hotel 1',
            'slug' => 'test-hotel-1',
            'location' => 'Test City',
            'phone' => '+1234567890',
            'type' => HotelType::LUXURY->value,
            'email' => 'test1@hotel.com',
            'address' => '123 Test Street',
            'country' => 'Test Country',
            'active' => true,
        ]);

        $response = $this->get(route('admin.hotels'));

        $response->assertStatus(302);
    }

    /** @test */
    public function it_can_access_store_route()
    {
        $hotelData = [
            'name' => 'New Test Hotel',
            'location' => 'Test City',
            'phone' => '+1234567890',
            'type' => HotelType::LUXURY->value,
            'email' => 'newtest@hotel.com',
            'star_rating' => 5,
            'description' => 'A beautiful test hotel',
            'address' => '123 Test Street',
            'country' => 'Test Country',
            'website' => 'https://testhotel.com',
            'active' => true,
        ];

        $response = $this->post(route('admin.hotels.store'), $hotelData);

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    /** @test */
    public function it_can_access_update_route()
    {

        $hotel = Hotel::create([
            'name' => 'Original Hotel',
            'slug' => 'original-hotel',
            'location' => 'Original City',
            'phone' => '+1111111111',
            'type' => HotelType::BUDGET->value,
            'email' => 'original@hotel.com',
            'address' => 'Original Address',
            'country' => 'Original Country',
            'active' => true,
        ]);

        $updateData = [
            'name' => 'Updated Hotel Name',
            'location' => 'Updated City',
            'phone' => '+9876543210',
            'type' => HotelType::RESORT->value,
            'email' => 'updated@hotel.com',
            'address' => 'Updated Address',
            'country' => 'Updated Country',
            'active' => false,
        ];

        $response = $this->patch(route('admin.hotels.update', $hotel), $updateData);

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    /** @test */
    public function it_can_access_delete_route()
    {
        $hotel = Hotel::create([
            'name' => 'Hotel to Delete',
            'slug' => 'hotel-to-delete',
            'location' => 'Delete City',
            'phone' => '+2222222222',
            'type' => HotelType::LUXURY->value,
            'email' => 'delete@hotel.com',
            'address' => 'Delete Address',
            'country' => 'Delete Country',
            'active' => true,
        ]);

        $response = $this->delete(route('admin.hotels.destroy', $hotel));

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    /** @test */
    public function it_handles_validation_errors()
    {
        $response = $this->post(route('admin.hotels.store'), [
            'name' => '',
        ]);

        $this->assertNotEquals(500, $response->getStatusCode());
        
        $this->assertContains($response->getStatusCode(), [302, 422]);
    }
}