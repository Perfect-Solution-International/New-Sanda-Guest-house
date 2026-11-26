<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Booking;
use App\Models\BookingAddon;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Setting;
use App\Services\BookingAvailabilityService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function create(Request $request): View
    {
        $roomTypes = RoomType::with('rooms')->where('status', 'active')->get();
        if ($roomTypes->isEmpty()) {
            $roomTypes = RoomType::all();
        }
        $addons = Addon::where('is_active', true)->get();
        $selectedRoomTypeId = $request->query('room_type_id');
        $checkIn = $request->query('check_in', Carbon::now()->format('Y-m-d'));
        $checkInTime = $request->query('check_in_time', '14:00');
        $checkOut = $request->query('check_out', Carbon::now()->addDay()->format('Y-m-d'));
        $checkOutTime = $request->query('check_out_time', '11:00');
        $adults = (int) $request->query('adults', 2);
        $children = (int) $request->query('children', 0);
        $settings = Setting::pluck('value', 'key');

        $checkInAt = BookingAvailabilityService::parseDateTime($checkIn, $checkInTime, '14:00');
        $checkOutAt = BookingAvailabilityService::parseDateTime($checkOut, $checkOutTime, '11:00');

        if ($checkOutAt->lte($checkInAt)) {
            $checkOutAt = $checkInAt->copy()->addDay()->setTime(11, 0);
            $checkOut = $checkOutAt->format('Y-m-d');
            $checkOutTime = $checkOutAt->format('H:i');
        }

        $initialAvailability = BookingAvailabilityService::getAvailability($checkInAt, $checkOutAt, $selectedRoomTypeId ? (int)$selectedRoomTypeId : null);

        return view('public.booking.create', compact(
            'roomTypes',
            'addons',
            'selectedRoomTypeId',
            'checkIn',
            'checkInTime',
            'checkOut',
            'checkOutTime',
            'adults',
            'children',
            'settings',
            'initialAvailability'
        ));
    }

    public function checkLiveAvailability(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'check_in_date' => 'required|date',
            'check_in_time' => 'nullable|string',
            'check_out_date' => 'required|date',
            'check_out_time' => 'nullable|string',
            'room_type_id' => 'nullable|integer',
            'exclude_booking_id' => 'nullable|integer',
        ]);

        $checkInAt = BookingAvailabilityService::parseDateTime($validated['check_in_date'], $validated['check_in_time'] ?? '14:00', '14:00');
        $checkOutAt = BookingAvailabilityService::parseDateTime($validated['check_out_date'], $validated['check_out_time'] ?? '11:00', '11:00');

        if ($checkOutAt->lte($checkInAt)) {
            return response()->json([
                'success' => false,
                'message' => 'Check-out date and time must be after check-in date and time.',
            ], 422);
        }

        $selectedTypeId = !empty($validated['room_type_id']) ? (int)$validated['room_type_id'] : null;
        $excludeId = !empty($validated['exclude_booking_id']) ? (int)$validated['exclude_booking_id'] : null;

        $availability = BookingAvailabilityService::getAvailability($checkInAt, $checkOutAt, $selectedTypeId, $excludeId);

        return response()->json([
            'success' => true,
            'data' => $availability,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'guest_name' => 'required|string|max:255',
            'guest_phone' => 'required|string|max:50',
            'guest_email' => 'nullable|email|max:255',
            'guest_nic_passport' => 'nullable|string|max:50',
            'guest_address' => 'nullable|string|max:500',
            'check_in_date' => 'required|date',
            'check_in_time' => 'nullable|string',
            'check_out_date' => 'required|date',
            'check_out_time' => 'nullable|string',
            'adults' => 'required|integer|min:1|max:20',
            'children' => 'nullable|integer|min:0|max:10',
            'payment_method' => 'required|string|in:bank_transfer,cash,card_at_desk',
            'special_requests' => 'nullable|string|max:1000',
            'addons' => 'nullable|array',
            'addons.*' => 'exists:addons,id',
            'addon_quantities' => 'nullable|array',
            'addon_quantities.*' => 'nullable|integer|min:1|max:50',
        ]);

        $checkInTime = !empty($validated['check_in_time']) ? $validated['check_in_time'] : '14:00';
        $checkOutTime = !empty($validated['check_out_time']) ? $validated['check_out_time'] : '11:00';

        $checkInAt = BookingAvailabilityService::parseDateTime($validated['check_in_date'], $checkInTime, '14:00');
        $checkOutAt = BookingAvailabilityService::parseDateTime($validated['check_out_date'], $checkOutTime, '11:00');

        if ($checkOutAt->lte($checkInAt)) {
            return back()->withInput()->with('error', 'Check-out date and time must be strictly after check-in date and time.');
        }

        $roomType = RoomType::findOrFail($validated['room_type_id']);

        // Overlap Validation: Check live availability
        $availability = BookingAvailabilityService::getAvailability($checkInAt, $checkOutAt, $roomType->id);
        $typeData = collect($availability['room_types'])->firstWhere('id', $roomType->id);

        if (!$typeData || $typeData['available_rooms'] <= 0) {
            return back()->withInput()->with('error', "Double booking prevented: All rooms for {$roomType->name} are already booked for {$checkInAt->format('M d, Y h:i A')} to {$checkOutAt->format('M d, Y h:i A')}. Please choose an alternative time slot or room category.");
        }

        // Calculate Duration
        $duration = BookingAvailabilityService::calculateDuration($checkInAt, $checkOutAt);
        $nights = $duration['nights'];
        $hours = $duration['hours'];
        $durationType = $duration['duration_type'];

        $roomRate = (float) $roomType->base_price_per_night;
        if ($nights >= 1) {
            $roomSubtotal = $roomRate * $nights;
        } else {
            // Day-use (minimum 60% of daily rate or pro-rated)
            $roomSubtotal = max(round($roomRate * ($hours / 24) * 1.2, 2), round($roomRate * 0.6, 2));
        }

        // Calculate Addons
        $addonsTotal = 0;
        $selectedAddons = [];
        if (!empty($validated['addons'])) {
            $addons = Addon::whereIn('id', $validated['addons'])->get();
            $customQuantities = $request->input('addon_quantities', []);

            foreach ($addons as $addon) {
                if (isset($customQuantities[$addon->id]) && (int)$customQuantities[$addon->id] >= 1) {
                    $qty = (int) $customQuantities[$addon->id];
                } elseif ($addon->price_type === 'per_person') {
                    $qty = $validated['adults'] + ($validated['children'] ?? 0);
                } elseif ($addon->price_type === 'per_night') {
                    $qty = max(1, $nights);
                } else {
                    $qty = 1;
                }

                if ($addon->price_type === 'per_night') {
                    $subtotal = $addon->price * $qty * max(1, $nights);
                } else {
                    $subtotal = $addon->price * $qty;
                }

                $addonsTotal += $subtotal;
                $selectedAddons[] = [
                    'addon_id' => $addon->id,
                    'quantity' => $qty,
                    'unit_price' => $addon->price,
                    'subtotal' => $subtotal,
                ];
            }
        }

        $totalAmount = $roomSubtotal + $addonsTotal;
        $bookingCode = Booking::generateBookingCode();

        // Assign physical free room for this time window if available
        $assignedRoom = BookingAvailabilityService::findFreeRoomForType($roomType->id, $checkInAt, $checkOutAt);

        // Fallback email if guest only entered phone/WhatsApp
        $guestEmail = !empty($validated['guest_email']) ? trim($validated['guest_email']) : ('guest_' . substr(preg_replace('/[^0-9]/', '', $validated['guest_phone']), -6) . '@sandaguesthouse.lk');

        $customer = Customer::firstOrCreate(
            ['phone' => $validated['guest_phone']],
            [
                'name' => $validated['guest_name'],
                'email' => $guestEmail,
                'nic_passport' => $validated['guest_nic_passport'] ?? null,
                'address' => $validated['guest_address'] ?? null,
            ]
        );

        $booking = Booking::create([
            'customer_id' => $customer->id,
            'booking_code' => $bookingCode,
            'room_type_id' => $roomType->id,
            'room_id' => $assignedRoom ? $assignedRoom->id : null,
            'guest_name' => $validated['guest_name'],
            'guest_email' => $guestEmail,
            'guest_phone' => $validated['guest_phone'],
            'guest_nic_passport' => $validated['guest_nic_passport'] ?? null,
            'guest_address' => $validated['guest_address'] ?? null,
            'check_in_date' => $checkInAt->format('Y-m-d'),
            'check_in_time' => $checkInTime,
            'check_out_date' => $checkOutAt->format('Y-m-d'),
            'check_out_time' => $checkOutTime,
            'check_in_at' => $checkInAt->format('Y-m-d H:i:s'),
            'check_out_at' => $checkOutAt->format('Y-m-d H:i:s'),
            'nights' => $nights,
            'duration_hours' => $hours,
            'duration_type' => $durationType,
            'adults' => $validated['adults'],
            'children' => $validated['children'] ?? 0,
            'room_rate' => $roomRate,
            'room_subtotal' => $roomSubtotal,
            'addons_total' => $addonsTotal,
            'total_amount' => $totalAmount,
            'advance_paid' => 0.00,
            'balance_due' => $totalAmount,
            'payment_status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'booking_status' => 'pending',
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        // Save addons
        foreach ($selectedAddons as $sa) {
            BookingAddon::create([
                'booking_id' => $booking->id,
                'addon_id' => $sa['addon_id'],
                'quantity' => $sa['quantity'],
                'unit_price' => $sa['unit_price'],
                'subtotal' => $sa['subtotal'],
            ]);
        }

        return redirect()->route('booking.confirmation', ['code' => $bookingCode])
            ->with('success', 'Your reservation at Sanda Guest House has been placed successfully!');
    }

    public function confirmation(string $code): View
    {
        $booking = Booking::with(['roomType', 'room', 'addons'])->where('booking_code', $code)->firstOrFail();
        $settings = Setting::pluck('value', 'key');

        return view('public.booking.confirmation', compact('booking', 'settings'));
    }

    public function track(Request $request): View
    {
        $prefillCode = trim($request->query('code', ''));
        $prefillPhone = trim($request->query('phone', ''));

        if ($prefillCode !== '' || $prefillPhone !== '') {
            $booking = $this->findBookingByCodeOrPhone($prefillCode, $prefillPhone);

            if ($booking) {
                $settings = Setting::pluck('value', 'key');
                return view('public.booking.status_result', compact('booking', 'settings'));
            }
        }

        return view('public.booking.track', compact('prefillCode', 'prefillPhone'));
    }

    public function checkStatus(Request $request): View|RedirectResponse
    {
        $code = trim($request->input('booking_code', ''));
        $phone = trim($request->input('phone', ''));

        if ($code === '' && $phone === '') {
            return back()->withInput()->with('error', 'Please enter your Booking Reference Number or registered Phone Number. (කරුණාකර ඔබගේ Booking Reference අංකය හෝ දුරකථන අංකය ඇතුළත් කරන්න).');
        }

        $booking = $this->findBookingByCodeOrPhone($code, $phone);

        if (!$booking) {
            $searched = $code !== '' ? $code : $phone;
            return back()->withInput()->with('error', "No reservation found matching '{$searched}'. Please check your reference code or contact Sanda Guest House reception (+94 77 987 6543 / WhatsApp).");
        }

        $settings = Setting::pluck('value', 'key');
        return view('public.booking.status_result', compact('booking', 'settings'));
    }

    /**
     * Smart flexible booking lookup by reference code, phone number, or both.
     */
    protected function findBookingByCodeOrPhone(?string $rawCode, ?string $rawPhone): ?Booking
    {
        $code = trim($rawCode ?? '');
        $phone = trim($rawPhone ?? '');

        if ($code === '' && $phone === '') {
            return null;
        }

        // 1. If Booking Code is provided:
        if ($code !== '') {
            $cleanCode = strtoupper(preg_replace('/\s+/', '', $code));

            $codeQuery = Booking::with(['roomType', 'room', 'addons', 'payments']);
            $codeQuery->where(function ($q) use ($cleanCode) {
                $q->where('booking_code', $cleanCode)
                  ->orWhere('booking_code', 'like', '%' . $cleanCode)
                  ->orWhere('booking_code', 'like', $cleanCode . '%');

                if (!str_starts_with($cleanCode, 'NS-')) {
                    $q->orWhere('booking_code', 'NS-2026-' . $cleanCode)
                      ->orWhere('booking_code', 'NS-' . $cleanCode);
                }
            });

            // If phone was ALSO entered, check if phone matches as well
            if ($phone !== '') {
                $bookingWithPhone = (clone $codeQuery);
                $this->applyPhoneFilter($bookingWithPhone, $phone);
                $found = $bookingWithPhone->latest('id')->first();
                if ($found) {
                    return $found;
                }
            }

            // Fallback: If phone didn't strictly match or wasn't provided,
            // return booking found by the unique booking code
            $booking = $codeQuery->latest('id')->first();
            if ($booking) {
                return $booking;
            }
        }

        // 2. If ONLY Phone is provided (no booking code)
        if ($phone !== '') {
            $phoneQuery = Booking::with(['roomType', 'room', 'addons', 'payments']);
            $this->applyPhoneFilter($phoneQuery, $phone);
            return $phoneQuery->latest('id')->first();
        }

        return null;
    }

    /**
     * Helper to apply flexible phone matching across various country codes and formatting.
     */
    protected function applyPhoneFilter($query, string $phone): void
    {
        $rawDigits = preg_replace('/[^0-9]/', '', $phone);
        $last7 = strlen($rawDigits) >= 7 ? substr($rawDigits, -7) : $rawDigits;
        $last9 = strlen($rawDigits) >= 9 ? substr($rawDigits, -9) : $rawDigits;

        $query->where(function ($q) use ($phone, $rawDigits, $last7, $last9) {
            $q->where('guest_phone', 'like', '%' . $phone . '%');

            if ($rawDigits !== '') {
                $q->orWhere('guest_phone', 'like', '%' . $rawDigits . '%');
            }

            if ($last9 !== '') {
                $q->orWhere('guest_phone', 'like', '%' . $last9 . '%');
            }

            if ($last7 !== '') {
                $q->orWhere('guest_phone', 'like', '%' . $last7 . '%')
                  ->orWhereRaw("REPLACE(REPLACE(REPLACE(guest_phone, ' ', ''), '-', ''), '+', '') LIKE ?", ['%' . $last7 . '%']);
            }
        });
    }

    /**
     * Check if user-provided phone loosely matches the booking's registered phone.
     */
    protected function isPhoneMatching(string $dbPhone, ?string $inputPhone): bool
    {
        if (empty($inputPhone)) {
            return true;
        }

        $inputDigits = preg_replace('/[^0-9]/', '', $inputPhone);
        $dbDigits = preg_replace('/[^0-9]/', '', $dbPhone);

        if (empty($inputDigits)) {
            return true;
        }

        $last7Input = strlen($inputDigits) >= 7 ? substr($inputDigits, -7) : $inputDigits;
        $last7Db = strlen($dbDigits) >= 7 ? substr($dbDigits, -7) : $dbDigits;

        return str_contains($dbDigits, $last7Input) 
            || str_contains($inputDigits, $last7Db)
            || str_contains($dbPhone, $inputPhone);
    }

    public function requestCancellation(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'phone' => 'nullable|string',
            'cancellation_reason' => 'required|string|max:500',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);

        if (!empty($validated['phone']) && !$this->isPhoneMatching($booking->guest_phone, $validated['phone'])) {
            return back()->with('error', 'Phone verification failed for this cancellation request.');
        }

        if (in_array($booking->booking_status, ['checked_in', 'checked_out'])) {
            return back()->with('error', 'In-house or completed stays cannot be cancelled online. Please speak directly with resort reception.');
        }

        if ($booking->booking_status === 'cancelled') {
            return back()->with('info', 'This reservation is already cancelled.');
        }

        $timestamp = now()->format('Y-m-d h:i A');
        $note = "\n[Guest Cancelled on {$timestamp}]: " . trim($validated['cancellation_reason']);
        $newRequests = trim(($booking->special_requests ?? '') . $note);

        $booking->update([
            'booking_status' => 'cancelled',
            'special_requests' => $newRequests,
        ]);

        // Release room if physical room was assigned
        if ($booking->room_id) {
            $room = Room::find($booking->room_id);
            if ($room && $room->status === 'occupied') {
                $room->update(['status' => 'available']);
            }
        }

        return redirect()->route('booking.track', [
            'code' => $booking->booking_code,
        ])->with('success', 'Your reservation has been cancelled successfully. Front desk has been notified.');
    }

    public function requestModification(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'phone' => 'nullable|string',
            'modification_note' => 'required|string|max:1000',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);

        if (!empty($validated['phone']) && !$this->isPhoneMatching($booking->guest_phone, $validated['phone'])) {
            return back()->with('error', 'Phone verification failed for this special request.');
        }

        if ($booking->booking_status === 'cancelled') {
            return back()->with('error', 'Cannot add requests to a cancelled reservation.');
        }

        $timestamp = now()->format('Y-m-d h:i A');
        $note = "\n[Guest Special Request on {$timestamp}]: " . trim($validated['modification_note']);
        $newRequests = trim(($booking->special_requests ?? '') . $note);

        $booking->update([
            'special_requests' => $newRequests,
        ]);

        return redirect()->route('booking.track', [
            'code' => $booking->booking_code,
        ])->with('success', 'Your special request has been sent to Sanda Guest House reception. Our team will review and update your stay.');
    }
}
