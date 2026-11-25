<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Booking;
use App\Models\BookingAddon;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Setting;
use App\Services\BookingAvailabilityService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingAdminController extends Controller
{
    public function index(Request $request): View
    {
        $query = Booking::with(['roomType', 'room'])->latest();

        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('booking_status', 'pending')->count(),
            'confirmed' => Booking::where('booking_status', 'confirmed')->count(),
            'checked_in' => Booking::where('booking_status', 'checked_in')->count(),
            'checked_out' => Booking::where('booking_status', 'checked_out')->count(),
            'cancelled' => Booking::where('booking_status', 'cancelled')->count(),
        ];

        if ($request->filled('status')) {
            $query->where('booking_status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function ($q) use ($s) {
                $q->where('booking_code', 'like', "%{$s}%")
                    ->orWhere('guest_name', 'like', "%{$s}%")
                    ->orWhere('guest_phone', 'like', "%{$s}%")
                    ->orWhere('guest_email', 'like', "%{$s}%");
            });
        }

        $bookings = $query->paginate(15)->withQueryString();
        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    public function create(): View
    {
        $roomTypes = RoomType::where('status', 'active')->get();
        if ($roomTypes->isEmpty()) {
            $roomTypes = RoomType::all();
        }
        $rooms = Room::with('roomType')->get();
        $addons = Addon::where('is_active', true)->get();

        $defaultCheckIn = date('Y-m-d');
        $defaultCheckInTime = '14:00';
        $defaultCheckOut = date('Y-m-d', strtotime('+1 day'));
        $defaultCheckOutTime = '11:00';

        return view('admin.bookings.create', compact(
            'roomTypes',
            'rooms',
            'addons',
            'defaultCheckIn',
            'defaultCheckInTime',
            'defaultCheckOut',
            'defaultCheckOutTime'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_id' => 'nullable|exists:rooms,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'nullable|email|max:255',
            'guest_phone' => 'required|string|max:50',
            'guest_nic_passport' => 'nullable|string|max:50',
            'guest_address' => 'nullable|string|max:500',
            'check_in_date' => 'required|date',
            'check_in_time' => 'nullable|string',
            'check_out_date' => 'required|date',
            'check_out_time' => 'nullable|string',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'room_rate' => 'required|numeric|min:0',
            'advance_paid' => 'nullable|numeric|min:0',
            'payment_status' => 'required|string',
            'payment_method' => 'required|string',
            'booking_status' => 'required|string',
            'special_requests' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'addons' => 'nullable|array',
        ]);

        $checkInTime = !empty($validated['check_in_time']) ? $validated['check_in_time'] : '14:00';
        $checkOutTime = !empty($validated['check_out_time']) ? $validated['check_out_time'] : '11:00';

        $checkInAt = BookingAvailabilityService::parseDateTime($validated['check_in_date'], $checkInTime, '14:00');
        $checkOutAt = BookingAvailabilityService::parseDateTime($validated['check_out_date'], $checkOutTime, '11:00');

        if ($checkOutAt->lte($checkInAt)) {
            return back()->withInput()->with('error', 'Check-out date/time must be strictly after check-in date/time.');
        }

        // Overlap Check for Physical Room
        if (!empty($validated['room_id'])) {
            $isFree = BookingAvailabilityService::isPhysicalRoomAvailable((int)$validated['room_id'], $checkInAt, $checkOutAt);
            if (!$isFree) {
                $conflictRoom = Room::find($validated['room_id']);
                return back()->withInput()->with('error', "Double-booking prevented: Physical room {$conflictRoom?->room_number} is already booked during {$checkInAt->format('M d, Y h:i A')} - {$checkOutAt->format('M d, Y h:i A')}.");
            }
        }

        $duration = BookingAvailabilityService::calculateDuration($checkInAt, $checkOutAt);
        $nights = $duration['nights'];
        $hours = $duration['hours'];
        $durationType = $duration['duration_type'];

        $roomRate = (float) $validated['room_rate'];
        if ($nights >= 1) {
            $roomSubtotal = $roomRate * $nights;
        } else {
            $roomSubtotal = max(round($roomRate * ($hours / 24) * 1.2, 2), round($roomRate * 0.6, 2));
        }

        $advancePaid = (float) ($validated['advance_paid'] ?? 0);

        $addonsTotal = 0;
        $selectedAddons = [];
        if (!empty($validated['addons'])) {
            $addons = Addon::whereIn('id', $validated['addons'])->get();
            foreach ($addons as $addon) {
                $qty = 1;
                if ($addon->price_type === 'per_night') {
                    $qty = max(1, $nights);
                } elseif ($addon->price_type === 'per_person') {
                    $qty = $validated['adults'] + ($validated['children'] ?? 0);
                }
                $sub = $addon->price * $qty;
                $addonsTotal += $sub;
                $selectedAddons[] = [
                    'addon_id' => $addon->id,
                    'quantity' => $qty,
                    'unit_price' => $addon->price,
                    'subtotal' => $sub,
                ];
            }
        }

        $totalAmount = $roomSubtotal + $addonsTotal;
        $balanceDue = max(0, $totalAmount - $advancePaid);

        $guestEmail = !empty($validated['guest_email']) ? trim($validated['guest_email']) : ('desk_' . substr(preg_replace('/[^0-9]/', '', $validated['guest_phone']), -6) . '@sandaguesthouse.lk');

        $booking = Booking::create([
            'booking_code' => Booking::generateBookingCode(),
            'room_type_id' => $validated['room_type_id'],
            'room_id' => $validated['room_id'] ?? null,
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
            'advance_paid' => $advancePaid,
            'balance_due' => $balanceDue,
            'payment_status' => $validated['payment_status'],
            'payment_method' => $validated['payment_method'],
            'booking_status' => $validated['booking_status'],
            'special_requests' => $validated['special_requests'] ?? null,
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        foreach ($selectedAddons as $sa) {
            BookingAddon::create([
                'booking_id' => $booking->id,
                'addon_id' => $sa['addon_id'],
                'quantity' => $sa['quantity'],
                'unit_price' => $sa['unit_price'],
                'subtotal' => $sa['subtotal'],
            ]);
        }

        // Update room status if checked in
        if (!empty($validated['room_id']) && $validated['booking_status'] === 'checked_in') {
            Room::where('id', $validated['room_id'])->update(['status' => 'occupied']);
        }

        return redirect()->route('admin.bookings.show', $booking->id)->with('success', 'Reservation created successfully!');
    }

    public function show(Booking $booking): View
    {
        $booking->load(['roomType', 'room', 'addons']);
        $rooms = Room::where('room_type_id', $booking->room_type_id)->get();
        return view('admin.bookings.show', compact('booking', 'rooms'));
    }

    public function edit(Booking $booking): View
    {
        $booking->load(['roomType', 'room', 'addons']);
        $roomTypes = RoomType::where('status', 'active')->get();
        if ($roomTypes->isEmpty()) {
            $roomTypes = RoomType::all();
        }
        $rooms = Room::with('roomType')->get();
        $addons = Addon::where('is_active', true)->get();
        return view('admin.bookings.edit', compact('booking', 'roomTypes', 'rooms', 'addons'));
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'guest_name' => 'sometimes|required|string|max:255',
            'guest_phone' => 'sometimes|required|string|max:50',
            'guest_email' => 'nullable|email|max:255',
            'guest_nic_passport' => 'nullable|string|max:50',
            'guest_address' => 'nullable|string|max:500',
            'room_type_id' => 'sometimes|required|exists:room_types,id',
            'room_id' => 'nullable|exists:rooms,id',
            'check_in_date' => 'sometimes|required|date',
            'check_in_time' => 'nullable|string',
            'check_out_date' => 'sometimes|required|date',
            'check_out_time' => 'nullable|string',
            'adults' => 'sometimes|required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'room_rate' => 'sometimes|required|numeric|min:0',
            'advance_paid' => 'required|numeric|min:0',
            'payment_status' => 'required|string',
            'payment_method' => 'required|string',
            'booking_status' => 'required|string',
            'special_requests' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'addons' => 'nullable|array',
            'addons.*' => 'exists:addons,id',
            'addons_form_present' => 'nullable|boolean',
        ]);

        $newRoomId = array_key_exists('room_id', $validated) ? $validated['room_id'] : $booking->room_id;

        // If dates are provided, parse exact datetime
        $checkInDate = $validated['check_in_date'] ?? $booking->check_in_date->format('Y-m-d');
        $checkInTime = $validated['check_in_time'] ?? ($booking->check_in_time ?: '14:00');
        $checkOutDate = $validated['check_out_date'] ?? $booking->check_out_date->format('Y-m-d');
        $checkOutTime = $validated['check_out_time'] ?? ($booking->check_out_time ?: '11:00');

        $checkInAt = BookingAvailabilityService::parseDateTime($checkInDate, $checkInTime, '14:00');
        $checkOutAt = BookingAvailabilityService::parseDateTime($checkOutDate, $checkOutTime, '11:00');

        if ($checkOutAt->lte($checkInAt)) {
            return back()->withInput()->with('error', 'Check-out date/time must be strictly after check-in date/time.');
        }

        // Overlap Check for Physical Room (excluding current booking)
        if (!empty($newRoomId) && $validated['booking_status'] !== 'cancelled') {
            $isFree = BookingAvailabilityService::isPhysicalRoomAvailable((int)$newRoomId, $checkInAt, $checkOutAt, $booking->id);
            if (!$isFree) {
                $conflictRoom = Room::find($newRoomId);
                return back()->withInput()->with('error', "Double-booking prevented: Room {$conflictRoom?->room_number} is already booked for another guest during this exact time range.");
            }
        }

        // Manage physical room status transitions
        if ($booking->room_id && $booking->room_id != $newRoomId) {
            Room::where('id', $booking->room_id)->update(['status' => 'available']);
        }

        if (!empty($newRoomId)) {
            if ($validated['booking_status'] === 'checked_in') {
                Room::where('id', $newRoomId)->update(['status' => 'occupied']);
            } elseif ($validated['booking_status'] === 'checked_out') {
                Room::where('id', $newRoomId)->update(['status' => 'cleaning']);
            } elseif (in_array($validated['booking_status'], ['cancelled', 'pending'])) {
                Room::where('id', $newRoomId)->update(['status' => 'available']);
            }
        }

        $advancePaid = (float) $validated['advance_paid'];

        $dataToUpdate = [
            'room_id' => $newRoomId,
            'advance_paid' => $advancePaid,
            'payment_status' => $validated['payment_status'],
            'payment_method' => $validated['payment_method'],
            'booking_status' => $validated['booking_status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
        ];

        // If submitted from full edit form
        if ($request->has('guest_name')) {
            $duration = BookingAvailabilityService::calculateDuration($checkInAt, $checkOutAt);
            $nights = $duration['nights'];
            $hours = $duration['hours'];
            $durationType = $duration['duration_type'];

            $roomRate = (float) $validated['room_rate'];
            if ($nights >= 1) {
                $roomSubtotal = $roomRate * $nights;
            } else {
                $roomSubtotal = max(round($roomRate * ($hours / 24) * 1.2, 2), round($roomRate * 0.6, 2));
            }

            $addonsTotal = 0;
            $selectedAddons = [];

            if ($request->filled('addons_form_present') || $request->has('addons')) {
                if (!empty($validated['addons'])) {
                    $addons = Addon::whereIn('id', $validated['addons'])->get();
                    foreach ($addons as $addon) {
                        $qty = 1;
                        if ($addon->price_type === 'per_night') {
                            $qty = max(1, $nights);
                        } elseif ($addon->price_type === 'per_person') {
                            $qty = $validated['adults'] + ($validated['children'] ?? 0);
                        }
                        $sub = $addon->price * $qty;
                        $addonsTotal += $sub;
                        $selectedAddons[] = [
                            'addon_id' => $addon->id,
                            'quantity' => $qty,
                            'unit_price' => $addon->price,
                            'subtotal' => $sub,
                        ];
                    }
                }

                // Sync addons
                BookingAddon::where('booking_id', $booking->id)->delete();
                foreach ($selectedAddons as $sa) {
                    BookingAddon::create([
                        'booking_id' => $booking->id,
                        'addon_id' => $sa['addon_id'],
                        'quantity' => $sa['quantity'],
                        'unit_price' => $sa['unit_price'],
                        'subtotal' => $sa['subtotal'],
                    ]);
                }
            } else {
                $addonsTotal = (float) $booking->addons_total;
            }

            $totalAmount = $roomSubtotal + $addonsTotal;
            $balanceDue = max(0, $totalAmount - $advancePaid);

            $guestEmail = !empty($validated['guest_email']) ? trim($validated['guest_email']) : ($booking->guest_email ?: 'guest@sandaguesthouse.lk');

            $dataToUpdate['guest_name'] = $validated['guest_name'];
            $dataToUpdate['guest_phone'] = $validated['guest_phone'];
            $dataToUpdate['guest_email'] = $guestEmail;
            $dataToUpdate['guest_nic_passport'] = $validated['guest_nic_passport'] ?? null;
            $dataToUpdate['guest_address'] = $validated['guest_address'] ?? null;
            $dataToUpdate['room_type_id'] = $validated['room_type_id'];
            $dataToUpdate['check_in_date'] = $checkInAt->format('Y-m-d');
            $dataToUpdate['check_in_time'] = $checkInTime;
            $dataToUpdate['check_out_date'] = $checkOutAt->format('Y-m-d');
            $dataToUpdate['check_out_time'] = $checkOutTime;
            $dataToUpdate['check_in_at'] = $checkInAt->format('Y-m-d H:i:s');
            $dataToUpdate['check_out_at'] = $checkOutAt->format('Y-m-d H:i:s');
            $dataToUpdate['nights'] = $nights;
            $dataToUpdate['duration_hours'] = $hours;
            $dataToUpdate['duration_type'] = $durationType;
            $dataToUpdate['adults'] = $validated['adults'];
            $dataToUpdate['children'] = $validated['children'] ?? 0;
            $dataToUpdate['room_rate'] = $roomRate;
            $dataToUpdate['room_subtotal'] = $roomSubtotal;
            $dataToUpdate['addons_total'] = $addonsTotal;
            $dataToUpdate['total_amount'] = $totalAmount;
            $dataToUpdate['balance_due'] = $balanceDue;
            $dataToUpdate['special_requests'] = $validated['special_requests'] ?? null;
        } else {
            // Quick update from show page
            $totalAmount = (float) $booking->total_amount;
            $balanceDue = max(0, $totalAmount - $advancePaid);
            $dataToUpdate['balance_due'] = $balanceDue;
        }

        $booking->update($dataToUpdate);

        return redirect()->route('admin.bookings.show', $booking->id)->with('success', 'Reservation updated successfully!');
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        if ($booking->room_id) {
            Room::where('id', $booking->room_id)->update(['status' => 'available']);
        }

        $booking->update([
            'booking_status' => 'cancelled',
        ]);

        return redirect()->back()->with('success', "Reservation #{$booking->booking_code} cancelled and room has been released to available.");
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        if ($booking->room_id) {
            Room::where('id', $booking->room_id)->update(['status' => 'available']);
        }
        BookingAddon::where('booking_id', $booking->id)->delete();
        $code = $booking->booking_code;
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', "Reservation #{$code} deleted successfully.");
    }

    public function invoice(Booking $booking): View
    {
        $booking->load(['roomType', 'room', 'addons']);
        $settings = Setting::pluck('value', 'key');
        return view('admin.bookings.invoice', compact('booking', 'settings'));
    }
}
