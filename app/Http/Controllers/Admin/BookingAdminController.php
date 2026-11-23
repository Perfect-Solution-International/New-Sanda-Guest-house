<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Booking;
use App\Models\BookingAddon;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingAdminController extends Controller
{
    public function index(Request $request): View
    {
        $query = Booking::with(['roomType', 'room'])->latest();

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
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create(): View
    {
        $roomTypes = RoomType::where('status', 'active')->get();
        $rooms = Room::all();
        $addons = Addon::where('is_active', true)->get();

        return view('admin.bookings.create', compact('roomTypes', 'rooms', 'addons'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_id' => 'nullable|exists:rooms,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:50',
            'guest_nic_passport' => 'nullable|string|max:50',
            'guest_address' => 'nullable|string|max:500',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
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

        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $nights = max(1, $checkIn->diffInDays($checkOut));

        $roomSubtotal = $validated['room_rate'] * $nights;
        $advancePaid = $validated['advance_paid'] ?? 0;

        $addonsTotal = 0;
        $selectedAddons = [];
        if (!empty($validated['addons'])) {
            $addons = Addon::whereIn('id', $validated['addons'])->get();
            foreach ($addons as $addon) {
                $qty = 1;
                if ($addon->price_type === 'per_night') {
                    $qty = $nights;
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

        $booking = Booking::create([
            'booking_code' => Booking::generateBookingCode(),
            'room_type_id' => $validated['room_type_id'],
            'room_id' => $validated['room_id'] ?? null,
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'],
            'guest_nic_passport' => $validated['guest_nic_passport'] ?? null,
            'guest_address' => $validated['guest_address'] ?? null,
            'check_in_date' => $checkIn->format('Y-m-d'),
            'check_out_date' => $checkOut->format('Y-m-d'),
            'nights' => $nights,
            'adults' => $validated['adults'],
            'children' => $validated['children'] ?? 0,
            'room_rate' => $validated['room_rate'],
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
        $roomTypes = RoomType::all();
        $rooms = Room::where('room_type_id', $booking->room_type_id)->get();
        return view('admin.bookings.edit', compact('booking', 'roomTypes', 'rooms'));
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'room_id' => 'nullable|exists:rooms,id',
            'advance_paid' => 'required|numeric|min:0',
            'payment_status' => 'required|string',
            'payment_method' => 'required|string',
            'booking_status' => 'required|string',
            'admin_notes' => 'nullable|string',
        ]);

        $totalAmount = $booking->total_amount;
        $advancePaid = (float) $validated['advance_paid'];
        $balanceDue = max(0, $totalAmount - $advancePaid);

        // Manage physical room status transitions
        if ($booking->room_id && $booking->room_id != $validated['room_id']) {
            Room::where('id', $booking->room_id)->update(['status' => 'available']);
        }

        if (!empty($validated['room_id'])) {
            if ($validated['booking_status'] === 'checked_in') {
                Room::where('id', $validated['room_id'])->update(['status' => 'occupied']);
            } elseif ($validated['booking_status'] === 'checked_out') {
                Room::where('id', $validated['room_id'])->update(['status' => 'cleaning']);
            }
        }

        $booking->update([
            'room_id' => $validated['room_id'] ?? null,
            'advance_paid' => $advancePaid,
            'balance_due' => $balanceDue,
            'payment_status' => $validated['payment_status'],
            'payment_method' => $validated['payment_method'],
            'booking_status' => $validated['booking_status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        return redirect()->route('admin.bookings.show', $booking->id)->with('success', 'Booking updated successfully!');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        if ($booking->room_id) {
            Room::where('id', $booking->room_id)->update(['status' => 'available']);
        }
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }

    public function invoice(Booking $booking): View
    {
        $booking->load(['roomType', 'room', 'addons']);
        $settings = Setting::pluck('value', 'key');
        return view('admin.bookings.invoice', compact('booking', 'settings'));
    }
}
