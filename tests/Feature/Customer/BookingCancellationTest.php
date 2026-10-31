<?php

namespace Tests\Feature\Customer;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\User;
use App\Services\Mail\BookingMailService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingCancellationTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_cancel_booking_from_history_without_a_reason_field(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $owner = User::factory()->create(['role' => 'owner']);
        $hotel = Hotel::create([
            'owner_id' => $owner->id,
            'name' => 'Test Hotel',
            'address' => '1 Test Street',
        ]);
        $booking = Booking::create([
            'customer_id' => $customer->id,
            'hotel_id' => $hotel->id,
            'booking_code' => 'TEST-CANCEL-001',
            'checkin_date' => now()->addDays(10)->toDateString(),
            'checkout_date' => now()->addDays(12)->toDateString(),
            'contact_name' => $customer->name,
            'contact_phone' => '0900000000',
            'contact_email' => $customer->email,
            'total_amount' => 100000,
            'status' => 'pending_payment',
        ]);

        $mailService = $this->mock(BookingMailService::class);
        $mailService->shouldReceive('sendBookingCancellation')->once();
        $mailService->shouldReceive('sendBookingCancellationToOwner')->once();

        $response = $this->actingAs($customer)
            ->post(route('customer.bookings.cancel', $booking));

        $response->assertRedirect(route('customer.bookings.show', $booking))
            ->assertSessionHas('success', 'Đơn đặt phòng đã được hủy.');

        $this->assertSame('cancelled', $booking->fresh()->status);
        $this->assertSame('Khách hàng hủy đơn.', $booking->fresh()->cancel_reason);
    }
}
