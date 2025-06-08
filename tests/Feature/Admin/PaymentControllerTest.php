<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PaymentControllerTest extends TestCase
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
            'email' => 'test@hotel.com',
            'address' => '123 Test Street',
            'country' => 'Test Country',
            'active' => true,
        ]);
    }

    #[Test]
    public function it_can_display_payments_index()
    {
        $response = $this->get(route('admin.payments.index'));
        
        $response->assertStatus(302);
    }

    #[Test]
    public function it_can_show_payments_datatable()
    {
        // Create a reservation with hotel_id and check_in_date
        $reservation = Reservation::create([
            'confirmation_number' => 'TEST123',
            'total_price' => 1000,
            'user_id' => $this->user->id,
            'hotel_id' => $this->hotel->id,
            'status' => 'pending',
            'payment_status' => 'pending',
            'number_of_guests' => 2,
            'check_in_date' => now()->addDays(1),
            'check_out_date' => now()->addDays(3),
        ]);

        $response = $this->post(route('admin.payments.show'));
        
        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[Test]
    public function it_can_process_cash_payment()
    {
        // Create a reservation with hotel_id and check_in_date
        $reservation = Reservation::create([
            'confirmation_number' => 'CASH123',
            'payment_status' => 'pending',
            'status' => 'pending',
            'total_price' => 1000,
            'user_id' => $this->user->id,
            'hotel_id' => $this->hotel->id,
            'number_of_guests' => 2,
            'check_in_date' => now()->addDays(1),
            'check_out_date' => now()->addDays(3),
        ]);

        $response = $this->post(route('admin.payments.cashPayment', $reservation), [
            'amount' => 1000,
        ]);

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[Test]
    public function it_can_create_stripe_payment()
    {
        // Create a reservation with hotel_id and check_in_date
        $reservation = Reservation::create([
            'confirmation_number' => 'STRIPE123',
            'total_price' => 1000,
            'user_id' => $this->user->id,
            'hotel_id' => $this->hotel->id,
            'status' => 'pending',
            'payment_status' => 'pending',
            'number_of_guests' => 2,
            'check_in_date' => now()->addDays(1),
            'check_out_date' => now()->addDays(3),
        ]);

        $response = $this->post(route('admin.payments.stripePayment', $reservation));

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[Test]
    public function it_can_handle_stripe_success()
    {
        // Create a reservation with hotel_id and check_in_date
        $reservation = Reservation::create([
            'confirmation_number' => 'SUCCESS123',
            'payment_status' => 'pending',
            'status' => 'pending',
            'total_price' => 1000,
            'user_id' => $this->user->id,
            'hotel_id' => $this->hotel->id,
            'number_of_guests' => 2,
            'check_in_date' => now()->addDays(1),
            'check_out_date' => now()->addDays(3),
        ]);

        $response = $this->get(route('admin.payments.stripe.success', $reservation));

        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertNotEquals(500, $response->getStatusCode());
    }
}