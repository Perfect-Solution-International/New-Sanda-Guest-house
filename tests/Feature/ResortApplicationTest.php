<?php

namespace Tests\Feature;

use App\Models\Addon;
use App\Models\Booking;
use App\Models\Inquiry;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResortApplicationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('New Sanda');
        $response->assertSee('Holiday Home');
        $response->assertSee('Sella Katharagama');
    }

    public function test_rooms_index_and_details_page_loads(): void
    {
        $response = $this->get('/rooms');
        $response->assertStatus(200);

        $room = RoomType::first();
        $response = $this->get("/rooms/{$room->slug}");
        $response->assertStatus(200);
        $response->assertSee($room->name);
    }

    public function test_guest_can_submit_booking_reservation(): void
    {
        $roomType = RoomType::first();
        $addon = Addon::first();

        $bookingData = [
            'room_type_id' => $roomType->id,
            'guest_name' => 'Sampath Kumarasinghe',
            'guest_email' => 'sampath@test.com',
            'guest_phone' => '+94 77 111 2233',
            'check_in_date' => now()->addDays(2)->format('Y-m-d'),
            'check_out_date' => now()->addDays(4)->format('Y-m-d'),
            'adults' => 2,
            'children' => 1,
            'payment_method' => 'bank_transfer',
            'special_requests' => 'Quiet cabana requested.',
            'addons' => [$addon->id],
        ];

        $response = $this->post('/book', $bookingData);
        $response->assertRedirect();

        $booking = Booking::where('guest_name', 'Sampath Kumarasinghe')->first();
        $this->assertNotNull($booking);
        $this->assertEquals(2, $booking->nights);
        $this->assertTrue($booking->total_amount > 0);
        $this->assertStringStartsWith('NS-', $booking->booking_code);

        // Check confirmation page
        $confirmResponse = $this->get("/booking-confirmation/{$booking->booking_code}");
        $confirmResponse->assertStatus(200);
        $confirmResponse->assertSee($booking->booking_code);
    }

    public function test_guest_can_track_booking_status(): void
    {
        $roomType = RoomType::first();
        $booking = Booking::create([
            'booking_code' => 'NS-2026-TEST9',
            'room_type_id' => $roomType->id,
            'guest_name' => 'Kanishka Test',
            'guest_email' => 'kanishka@test.com',
            'guest_phone' => '+94 77 123 4567',
            'check_in_date' => now()->format('Y-m-d'),
            'check_out_date' => now()->addDays(2)->format('Y-m-d'),
            'nights' => 2,
            'adults' => 2,
            'children' => 0,
            'room_rate' => 20000,
            'room_subtotal' => 40000,
            'total_amount' => 40000,
            'balance_due' => 40000,
            'booking_status' => 'confirmed',
        ]);

        $response = $this->post('/track-booking', [
            'booking_code' => $booking->booking_code,
            'phone' => substr($booking->guest_phone, -7),
        ]);

        $response->assertStatus(200);
        $response->assertSee($booking->booking_code);
        $response->assertSee($booking->guest_name);
    }

    public function test_guest_can_send_inquiry(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Mahesh Fernando',
            'email' => 'mahesh@test.com',
            'phone' => '+94 71 222 3344',
            'subject' => 'Group booking 15 persons',
            'message' => 'Please provide meal package options.',
        ]);

        $response->assertRedirect('/contact');
        $this->assertDatabaseHas('inquiries', ['name' => 'Mahesh Fernando']);
    }

    public function test_admin_can_login_and_access_dashboard(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@newsandaresort.com',
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticated();

        $dashboardResponse = $this->get('/admin');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Dashboard & Operational Overview');
    }

    public function test_admin_can_update_booking_and_assign_room(): void
    {
        $admin = User::first();
        $roomType = RoomType::first();
        $booking = Booking::create([
            'booking_code' => 'NS-2026-TEST8',
            'room_type_id' => $roomType->id,
            'guest_name' => 'Ruwan Test',
            'guest_email' => 'ruwan@test.com',
            'guest_phone' => '+94 71 889 2211',
            'check_in_date' => now()->format('Y-m-d'),
            'check_out_date' => now()->addDays(1)->format('Y-m-d'),
            'nights' => 1,
            'adults' => 2,
            'children' => 0,
            'room_rate' => 22000,
            'room_subtotal' => 22000,
            'total_amount' => 22000,
            'balance_due' => 22000,
            'booking_status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'cash',
        ]);
        $room = Room::where('room_type_id', $booking->room_type_id)->first();

        $response = $this->actingAs($admin)->put("/admin/bookings/{$booking->id}", [
            'room_id' => $room->id,
            'advance_paid' => 15000,
            'payment_status' => 'advance_paid',
            'payment_method' => 'bank_transfer',
            'booking_status' => 'confirmed',
            'admin_notes' => 'Advance verified by manager',
        ]);

        $response->assertRedirect();
        $booking->refresh();
        $this->assertEquals('confirmed', $booking->booking_status);
        $this->assertEquals($room->id, $booking->room_id);
    }

    public function test_admin_invoice_view_renders(): void
    {
        $admin = User::first();
        $roomType = RoomType::first();
        $booking = Booking::create([
            'booking_code' => 'NS-2026-INV1',
            'room_type_id' => $roomType->id,
            'guest_name' => 'Invoice Test',
            'guest_email' => 'inv@test.com',
            'guest_phone' => '+94 77 999 0000',
            'check_in_date' => now()->format('Y-m-d'),
            'check_out_date' => now()->addDays(1)->format('Y-m-d'),
            'nights' => 1,
            'adults' => 2,
            'children' => 0,
            'room_rate' => 20000,
            'room_subtotal' => 20000,
            'total_amount' => 20000,
            'balance_due' => 20000,
            'booking_status' => 'confirmed',
            'payment_status' => 'paid_in_full',
            'payment_method' => 'cash',
        ]);

        $response = $this->actingAs($admin)->get("/admin/bookings/{$booking->id}/invoice");
        $response->assertStatus(200);
        $response->assertSee($booking->booking_code);
        $response->assertSee('Guest Invoice');
    }
}
