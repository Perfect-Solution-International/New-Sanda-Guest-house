<?php

namespace Tests\Feature;

use App\Models\Addon;
use App\Models\Booking;
use App\Models\Inquiry;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
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
        $response->assertSee('Sanda');
        $response->assertSee('Guest House');
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

    public function test_unauthenticated_user_accessing_admin_is_redirected_to_login(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');

        $loginResponse = $this->get('/login');
        $loginResponse->assertRedirect('/admin/login');
    }

    public function test_admin_can_login_and_access_dashboard(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@sandaresort.com',
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

    public function test_admin_can_view_edit_booking_page(): void
    {
        $admin = User::first();
        $roomType = RoomType::first();
        $booking = Booking::create([
            'booking_code' => 'NS-2026-VIEW1',
            'room_type_id' => $roomType->id,
            'guest_name' => 'View Edit Test',
            'guest_email' => 'viewedit@test.com',
            'guest_phone' => '+94 77 111 4455',
            'check_in_date' => now()->format('Y-m-d'),
            'check_out_date' => now()->addDays(2)->format('Y-m-d'),
            'nights' => 2,
            'adults' => 2,
            'children' => 0,
            'room_rate' => 20000,
            'room_subtotal' => 40000,
            'total_amount' => 40000,
            'balance_due' => 40000,
            'booking_status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'cash',
        ]);

        $response = $this->actingAs($admin)->get("/admin/bookings/{$booking->id}/edit");
        $response->assertStatus(200);
        $response->assertSee('Edit Reservation');
        $response->assertSee($booking->booking_code);
        $response->assertSee($booking->guest_name);
    }

    public function test_admin_can_fully_update_booking_details(): void
    {
        $admin = User::first();
        $roomType = RoomType::first();
        $booking = Booking::create([
            'booking_code' => 'NS-2026-UPD1',
            'room_type_id' => $roomType->id,
            'guest_name' => 'Initial Guest Name',
            'guest_email' => 'initial@guest.com',
            'guest_phone' => '+94 77 999 8888',
            'check_in_date' => now()->format('Y-m-d'),
            'check_out_date' => now()->addDays(2)->format('Y-m-d'),
            'nights' => 2,
            'adults' => 2,
            'children' => 0,
            'room_rate' => 20000,
            'room_subtotal' => 40000,
            'total_amount' => 40000,
            'balance_due' => 40000,
            'booking_status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'cash',
        ]);
        $room = Room::where('room_type_id', $roomType->id)->first();

        $response = $this->actingAs($admin)->put("/admin/bookings/{$booking->id}", [
            'guest_name' => 'Updated Guest Name',
            'guest_phone' => '+94 77 000 1122',
            'guest_email' => 'updated@guest.com',
            'guest_nic_passport' => '200012345678',
            'guest_address' => 'Colombo, Sri Lanka',
            'room_type_id' => $roomType->id,
            'room_id' => $room->id,
            'check_in_date' => now()->addDays(5)->format('Y-m-d'),
            'check_out_date' => now()->addDays(8)->format('Y-m-d'),
            'adults' => 3,
            'children' => 1,
            'room_rate' => 18000,
            'advance_paid' => 20000,
            'payment_status' => 'advance_paid',
            'payment_method' => 'card_at_desk',
            'booking_status' => 'confirmed',
            'special_requests' => 'Late checkout requested',
            'admin_notes' => 'Confirmed with guest via WhatsApp',
        ]);

        $response->assertRedirect("/admin/bookings/{$booking->id}");
        $booking->refresh();
        $this->assertEquals('Updated Guest Name', $booking->guest_name);
        $this->assertEquals('+94 77 000 1122', $booking->guest_phone);
        $this->assertEquals(3, $booking->nights);
        $this->assertEquals(54000, $booking->room_subtotal);
        $this->assertEquals(20000, $booking->advance_paid);
        $this->assertEquals(34000, $booking->balance_due);
    }

    public function test_admin_can_delete_booking_and_free_room(): void
    {
        $admin = User::first();
        $room = Room::first();
        $room->update(['status' => 'occupied']);

        $booking = Booking::create([
            'booking_code' => 'NS-DEL-001',
            'room_type_id' => $room->room_type_id,
            'room_id' => $room->id,
            'guest_name' => 'To Be Deleted',
            'guest_email' => 'delete@test.com',
            'guest_phone' => '+94 77 333 4444',
            'check_in_date' => now()->format('Y-m-d'),
            'check_out_date' => now()->addDays(2)->format('Y-m-d'),
            'nights' => 2,
            'adults' => 2,
            'children' => 0,
            'room_rate' => 15000,
            'room_subtotal' => 30000,
            'total_amount' => 30000,
            'advance_paid' => 0,
            'balance_due' => 30000,
            'booking_status' => 'checked_in',
            'payment_status' => 'pending',
            'payment_method' => 'cash',
        ]);

        $response = $this->actingAs($admin)->delete("/admin/bookings/{$booking->id}");
        $response->assertRedirect('/admin/bookings');
        $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);

        $room->refresh();
        $this->assertEquals('available', $room->status);
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

    public function test_superadmin_can_login_via_post(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'superadmin@pos.lk',
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticated();
    }

    public function test_superadmin_can_login_with_custom_password(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'superadmin@pos.lk',
            'password' => 'MyNewSecretPassword!',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticated();
    }

    public function test_admin_can_create_room_with_uploaded_image(): void
    {
        $admin = User::first();
        $file = UploadedFile::fake()->create('test_deluxe_room.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($admin)->post('/admin/room-types', [
            'name' => 'Royal Suite with Garden View',
            'short_description' => 'A luxury stay with private balcony.',
            'description' => 'Full detailed description for Royal Suite.',
            'base_price_per_night' => 12500,
            'max_adults' => 3,
            'max_children' => 1,
            'bed_type' => '1 King Bed + 1 Single Bed',
            'room_size' => '400 sq ft',
            'image_file' => $file,
            'status' => 'active',
        ]);

        $response->assertRedirect('/admin/room-types');
        $this->assertDatabaseHas('room_types', [
            'name' => 'Royal Suite with Garden View',
        ]);

        $room = RoomType::where('name', 'Royal Suite with Garden View')->first();
        $this->assertNotNull($room->image);
        $this->assertStringContainsString('uploads/rooms/', $room->image);
    }

    public function test_live_availability_api_endpoint_calculates_correct_counts_and_duration(): void
    {
        $inDate = now()->addDays(10)->format('Y-m-d');
        $outDate = now()->addDays(12)->format('Y-m-d');

        $response = $this->getJson("/api/availability?check_in_date={$inDate}&check_in_time=14:00&check_out_date={$outDate}&check_out_time=11:00");

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'total_rooms',
                'available_rooms',
                'booked_rooms',
                'duration' => [
                    'nights',
                    'hours',
                    'duration_text',
                ],
                'room_types',
                'rooms_schedule',
            ],
        ]);

        $data = $response->json('data');
        $this->assertEquals(6, $data['total_rooms']);
        $this->assertEquals(2, $data['duration']['nights']);
        $this->assertEquals(45, round($data['duration']['hours']));
        $this->assertNotEmpty($data['rooms_schedule']);
        $this->assertArrayHasKey('room_number', $data['rooms_schedule'][0]);
        $this->assertArrayHasKey('booked_slots', $data['rooms_schedule'][0]);
    }

    public function test_guest_can_book_with_name_whatsapp_and_exact_times(): void
    {
        $roomType = RoomType::first();
        $inDate = now()->addDays(20)->format('Y-m-d');
        $outDate = now()->addDays(21)->format('Y-m-d');

        $response = $this->post('/book', [
            'room_type_id' => $roomType->id,
            'guest_name' => 'WhatsApp Guest Test',
            'guest_phone' => '+94 77 123 9999',
            'check_in_date' => $inDate,
            'check_in_time' => '15:00',
            'check_out_date' => $outDate,
            'check_out_time' => '10:00',
            'adults' => 2,
            'children' => 0,
            'payment_method' => 'cash',
        ]);

        $response->assertRedirect();

        $booking = Booking::where('guest_name', 'WhatsApp Guest Test')->first();
        $this->assertNotNull($booking);
        $this->assertEquals('+94 77 123 9999', $booking->guest_phone);
        $this->assertEquals('15:00', $booking->check_in_time);
        $this->assertEquals('10:00', $booking->check_out_time);
        $this->assertNotNull($booking->check_in_at);
        $this->assertNotNull($booking->check_out_at);
        $this->assertNotNull($booking->room_id);
    }

    public function test_overlap_prevention_blocks_double_booking(): void
    {
        $roomType = RoomType::first();
        $roomsCount = Room::where('room_type_id', $roomType->id)->count();

        $inDate = now()->addDays(30)->format('Y-m-d');
        $outDate = now()->addDays(32)->format('Y-m-d');

        // Book all available physical rooms for this category
        for ($i = 0; $i < $roomsCount; $i++) {
            $this->post('/book', [
                'room_type_id' => $roomType->id,
                'guest_name' => "Booking {$i}",
                'guest_phone' => "+94 77 000 000{$i}",
                'check_in_date' => $inDate,
                'check_in_time' => '14:00',
                'check_out_date' => $outDate,
                'check_out_time' => '11:00',
                'adults' => 2,
                'payment_method' => 'cash',
            ]);
        }

        // Attempt one more booking in the overlapping slot
        $overlapResponse = $this->post('/book', [
            'room_type_id' => $roomType->id,
            'guest_name' => 'Overlapping Guest',
            'guest_phone' => '+94 77 888 8888',
            'check_in_date' => $inDate,
            'check_in_time' => '14:00',
            'check_out_date' => $outDate,
            'check_out_time' => '11:00',
            'adults' => 2,
            'payment_method' => 'cash',
        ]);

        $overlapResponse->assertSessionHas('error');
        $this->assertDatabaseMissing('bookings', [
            'guest_name' => 'Overlapping Guest',
        ]);
    }

    public function test_admin_can_cancel_booking_and_release_room(): void
    {
        $admin = User::first();
        $room = Room::first();
        $room->update(['status' => 'occupied']);

        $booking = Booking::create([
            'booking_code' => 'NS-CANCEL-001',
            'room_type_id' => $room->room_type_id,
            'room_id' => $room->id,
            'guest_name' => 'Cancel Target Guest',
            'guest_email' => 'cancel@test.com',
            'guest_phone' => '+94 77 555 6666',
            'check_in_date' => now()->format('Y-m-d'),
            'check_in_time' => '14:00',
            'check_out_date' => now()->addDays(2)->format('Y-m-d'),
            'check_out_time' => '11:00',
            'check_in_at' => now()->setTime(14, 0),
            'check_out_at' => now()->addDays(2)->setTime(11, 0),
            'nights' => 2,
            'duration_hours' => 45,
            'duration_type' => 'nights',
            'adults' => 2,
            'children' => 0,
            'room_rate' => 15000,
            'room_subtotal' => 30000,
            'total_amount' => 30000,
            'advance_paid' => 10000,
            'balance_due' => 20000,
            'booking_status' => 'confirmed',
            'payment_status' => 'advance_paid',
            'payment_method' => 'cash',
        ]);

        $response = $this->actingAs($admin)->post("/admin/bookings/{$booking->id}/cancel");
        $response->assertRedirect();

        $booking->refresh();
        $this->assertEquals('cancelled', $booking->booking_status);

        $room->refresh();
        $this->assertEquals('available', $room->status);
    }

    public function test_guest_cannot_access_timeline_without_login(): void
    {
        $response = $this->get('/admin/timeline');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_view_room_availability_timeline(): void
    {
        $admin = User::first();
        $response = $this->actingAs($admin)->get('/admin/timeline');
        $response->assertStatus(200);
        $response->assertSee('Visual Room Schedule');
        $response->assertSee('Room');
        $response->assertSee('Timeline &amp; Calendar', false);
    }

    public function test_admin_dashboard_shows_revenue_and_room_metrics(): void
    {
        $admin = User::first();
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Revenue Overview');
        $response->assertSee('This Month:');
        $response->assertSee('Today:');
        $response->assertSee('Rooms Available');
        $response->assertSee('Availability Timeline');
    }

    public function test_database_has_normalized_rooms_bookings_customers_payments_and_admins_tables(): void
    {
        $this->assertTrue(\Illuminate\Support\Facades\Schema::hasTable('rooms'));
        $this->assertTrue(\Illuminate\Support\Facades\Schema::hasTable('bookings'));
        $this->assertTrue(\Illuminate\Support\Facades\Schema::hasTable('customers'));
        $this->assertTrue(\Illuminate\Support\Facades\Schema::hasTable('payments'));
        $this->assertTrue(\Illuminate\Support\Facades\Schema::hasTable('admins'));

        $this->assertTrue(\Illuminate\Support\Facades\Schema::hasColumn('bookings', 'customer_id'));
        $this->assertTrue(\Illuminate\Support\Facades\Schema::hasColumn('payments', 'booking_id'));
    }

    public function test_guest_can_lookup_booking_status(): void
    {
        $room = Room::first();
        $booking = Booking::create([
            'booking_code' => 'NS-TEST-LOOKUP',
            'room_type_id' => $room->room_type_id,
            'room_id' => $room->id,
            'guest_name' => 'Lookup Guest Test',
            'guest_email' => 'lookup@test.com',
            'guest_phone' => '+94 77 111 2233',
            'check_in_date' => now()->addDays(2)->format('Y-m-d'),
            'check_in_time' => '14:00',
            'check_out_date' => now()->addDays(3)->format('Y-m-d'),
            'check_out_time' => '11:00',
            'nights' => 1,
            'adults' => 2,
            'room_rate' => 10000,
            'room_subtotal' => 10000,
            'total_amount' => 10000,
            'advance_paid' => 0,
            'balance_due' => 10000,
            'booking_status' => 'confirmed',
            'payment_status' => 'pending',
            'payment_method' => 'cash',
        ]);

        // 1. Lookup with reference code alone
        $responseCodeOnly = $this->post('/track-booking', [
            'booking_code' => $booking->booking_code,
        ]);
        $responseCodeOnly->assertStatus(200);
        $responseCodeOnly->assertSee($booking->booking_code);
        $responseCodeOnly->assertSee('Lookup Guest Test');

        // 2. Lookup with lowercase reference code
        $responseLower = $this->post('/track-booking', [
            'booking_code' => 'ns-test-lookup',
        ]);
        $responseLower->assertStatus(200);
        $responseLower->assertSee($booking->booking_code);

        // 3. Lookup with phone number alone (matching local format against international)
        $responsePhoneOnly = $this->post('/track-booking', [
            'phone' => '077 111 2233',
        ]);
        $responsePhoneOnly->assertStatus(200);
        $responsePhoneOnly->assertSee($booking->booking_code);

        // 4. Lookup via direct link GET /track-booking?code=...
        $responseGet = $this->get('/track-booking?code=' . $booking->booking_code);
        $responseGet->assertStatus(200);
        $responseGet->assertSee($booking->booking_code);
        $responseGet->assertSee('Guest Self-Service Portal');
    }

    public function test_guest_can_submit_special_modification_request(): void
    {
        $room = Room::first();
        $booking = Booking::create([
            'booking_code' => 'NS-TEST-MODIFY',
            'room_type_id' => $room->room_type_id,
            'room_id' => $room->id,
            'guest_name' => 'Modify Guest Test',
            'guest_email' => 'modify@test.com',
            'guest_phone' => '+94 77 444 5566',
            'check_in_date' => now()->addDays(2)->format('Y-m-d'),
            'check_in_time' => '14:00',
            'check_out_date' => now()->addDays(3)->format('Y-m-d'),
            'check_out_time' => '11:00',
            'nights' => 1,
            'adults' => 2,
            'room_rate' => 10000,
            'room_subtotal' => 10000,
            'total_amount' => 10000,
            'advance_paid' => 0,
            'balance_due' => 10000,
            'booking_status' => 'confirmed',
            'payment_status' => 'pending',
            'payment_method' => 'cash',
        ]);

        $response = $this->post('/track-booking/modify', [
            'booking_id' => $booking->id,
            'phone' => $booking->guest_phone,
            'modification_note' => 'Please arrange an extra pillow and hot water at 7 PM.',
        ]);

        $response->assertRedirect();
        $booking->refresh();
        $this->assertStringContainsString('extra pillow and hot water', $booking->special_requests);
    }

    public function test_guest_can_cancel_booking_online(): void
    {
        $room = Room::first();
        $room->update(['status' => 'occupied']);

        $booking = Booking::create([
            'booking_code' => 'NS-SELF-CANCEL',
            'room_type_id' => $room->room_type_id,
            'room_id' => $room->id,
            'guest_name' => 'Self Cancel Guest',
            'guest_email' => 'selfcancel@test.com',
            'guest_phone' => '+94 71 999 1111',
            'check_in_date' => now()->addDays(5)->format('Y-m-d'),
            'check_in_time' => '14:00',
            'check_out_date' => now()->addDays(6)->format('Y-m-d'),
            'check_out_time' => '11:00',
            'nights' => 1,
            'adults' => 2,
            'room_rate' => 12000,
            'room_subtotal' => 12000,
            'total_amount' => 12000,
            'advance_paid' => 0,
            'balance_due' => 12000,
            'booking_status' => 'confirmed',
            'payment_status' => 'pending',
            'payment_method' => 'cash',
        ]);

        $response = $this->post('/track-booking/cancel', [
            'booking_id' => $booking->id,
            'phone' => '+94 71 999 1111',
            'cancellation_reason' => 'Change of travel dates or itinerary',
        ]);

        $response->assertRedirect();
        $booking->refresh();
        $this->assertEquals('cancelled', $booking->booking_status);
        $this->assertStringContainsString('Change of travel dates or itinerary', $booking->special_requests);

        $room->refresh();
        $this->assertEquals('available', $room->status);
    }

    public function test_guest_can_book_with_custom_addon_person_quantity(): void
    {
        $roomType = RoomType::first();
        $addon = Addon::first();

        $inDate = now()->addDays(14)->format('Y-m-d');
        $outDate = now()->addDays(15)->format('Y-m-d');

        $response = $this->post('/book', [
            'room_type_id' => $roomType->id,
            'guest_name' => 'Addon Person Test Guest',
            'guest_phone' => '+94 77 333 4444',
            'check_in_date' => $inDate,
            'check_in_time' => '14:00',
            'check_out_date' => $outDate,
            'check_out_time' => '11:00',
            'adults' => 2,
            'children' => 0,
            'payment_method' => 'cash',
            'addons' => [$addon->id],
            'addon_quantities' => [
                $addon->id => 3, // 3 persons / units
            ],
        ]);

        $response->assertRedirect();

        $booking = Booking::where('guest_name', 'Addon Person Test Guest')->first();
        $this->assertNotNull($booking);

        $bookingAddon = \App\Models\BookingAddon::where('booking_id', $booking->id)
            ->where('addon_id', $addon->id)
            ->first();

        $this->assertNotNull($bookingAddon);
        $this->assertEquals(3, $bookingAddon->quantity);
        $this->assertEquals($addon->price * 3, $bookingAddon->subtotal);
    }

    public function test_admin_can_view_customers_list_and_filter(): void
    {
        $admin = User::first();
        $this->actingAs($admin);

        $vipCustomer = \App\Models\Customer::create([
            'name' => 'VIP Customer Test',
            'phone' => '+94 77 999 1111',
            'email' => 'vip@test.com',
            'is_vip' => true,
        ]);

        $blacklistedCustomer = \App\Models\Customer::create([
            'name' => 'Blacklisted Guest Test',
            'phone' => '+94 77 999 2222',
            'email' => 'bad@test.com',
            'is_blacklisted' => true,
            'blacklist_reason' => 'Property damage on last stay',
        ]);

        $response = $this->get('/admin/customers');
        $response->assertStatus(200);
        $response->assertSee('VIP Customer Test');
        $response->assertSee('Blacklisted Guest Test');
        $response->assertSee('Guest Directory');

        // Test VIP filter
        $responseVip = $this->get('/admin/customers?filter=vip');
        $responseVip->assertStatus(200);
        $responseVip->assertSee('VIP Customer Test');
        $responseVip->assertDontSee('Blacklisted Guest Test');

        // Test Blacklist filter
        $responseBlack = $this->get('/admin/customers?filter=blacklisted');
        $responseBlack->assertStatus(200);
        $responseBlack->assertSee('Blacklisted Guest Test');
        $responseBlack->assertDontSee('VIP Customer Test');
    }

    public function test_admin_can_view_customer_profile_and_stay_history(): void
    {
        $admin = User::first();
        $this->actingAs($admin);
        $room = Room::first();

        $customer = \App\Models\Customer::create([
            'name' => 'History Guest Test',
            'phone' => '+94 77 888 3333',
            'email' => 'history@test.com',
            'special_preferences' => 'Prefers ground floor room',
        ]);

        $booking = Booking::create([
            'customer_id' => $customer->id,
            'booking_code' => 'NS-HIST-001',
            'room_type_id' => $room->room_type_id,
            'room_id' => $room->id,
            'guest_name' => $customer->name,
            'guest_email' => $customer->email,
            'guest_phone' => $customer->phone,
            'check_in_date' => now()->format('Y-m-d'),
            'check_in_time' => '14:00',
            'check_out_date' => now()->addDay()->format('Y-m-d'),
            'check_out_time' => '11:00',
            'nights' => 1,
            'adults' => 2,
            'room_rate' => 8000,
            'room_subtotal' => 8000,
            'total_amount' => 8000,
            'advance_paid' => 4000,
            'balance_due' => 4000,
            'booking_status' => 'confirmed',
            'payment_status' => 'partial',
            'payment_method' => 'cash',
        ]);

        $response = $this->get("/admin/customers/{$customer->id}");
        $response->assertStatus(200);
        $response->assertSee('History Guest Test');
        $response->assertSee('NS-HIST-001');
        $response->assertSee('Prefers ground floor room');
    }

    public function test_admin_can_toggle_blacklist_and_vip_status(): void
    {
        $admin = User::first();
        $this->actingAs($admin);

        $customer = \App\Models\Customer::create([
            'name' => 'Toggle Status Test',
            'phone' => '+94 77 555 4444',
            'email' => 'toggle@test.com',
        ]);

        // 1. Toggle VIP
        $this->post("/admin/customers/{$customer->id}/toggle-vip");
        $this->assertTrue($customer->fresh()->is_vip);

        // 2. Toggle Blacklist on
        $this->post("/admin/customers/{$customer->id}/toggle-blacklist", [
            'is_blacklisted' => 1,
            'blacklist_reason' => 'Disruptive behavior',
        ]);
        $customer->refresh();
        $this->assertTrue($customer->is_blacklisted);
        $this->assertEquals('Disruptive behavior', $customer->blacklist_reason);

        // 3. Toggle Blacklist off
        $this->post("/admin/customers/{$customer->id}/toggle-blacklist", [
            'is_blacklisted' => 0,
        ]);
        $this->assertFalse($customer->fresh()->is_blacklisted);
    }

    public function test_blacklisted_customer_cannot_book_online(): void
    {
        $blacklisted = \App\Models\Customer::create([
            'name' => 'Blocked Book Test',
            'phone' => '+94 77 000 9999',
            'email' => 'blocked@test.com',
            'is_blacklisted' => true,
            'blacklist_reason' => 'Refused payment',
        ]);

        $roomType = RoomType::first();

        $response = $this->post('/book', [
            'room_type_id' => $roomType->id,
            'guest_name' => 'Blocked Book Test',
            'guest_phone' => '+94 77 000 9999',
            'guest_email' => 'blocked@test.com',
            'check_in_date' => now()->addDays(5)->format('Y-m-d'),
            'check_in_time' => '14:00',
            'check_out_date' => now()->addDays(6)->format('Y-m-d'),
            'check_out_time' => '11:00',
            'adults' => 2,
            'payment_method' => 'cash',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('bookings', [
            'guest_phone' => '+94 77 000 9999',
        ]);
    }
}
