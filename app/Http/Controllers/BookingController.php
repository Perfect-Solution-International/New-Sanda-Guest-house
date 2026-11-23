<?php

namespace App\Http\Controllers;

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

class BookingController extends Controller
{
    public function create(Request $request): View
    {
        $roomTypes = RoomType::with('rooms')->where('status', 'active')->get();
        $addons = Addon::where('is_active', true)->get();
        $selectedRoomTypeId = $request->query('room_type_id');
        $checkIn = $request->query('check_in', Carbon::now()->addDay()->format('Y-m-d'));
        $checkOut = $request->query('check_out', Carbon::now()->addDays(2)->format('Y-m-d'));
        $adults = (int) $request->query('adults', 2);
        $children = (int) $request->query('children', 0);
        $settings = Setting::pluck('value', 'key');

        return view('public.booking.create', compact(
            'roomTypes',
            'addons',
            'selectedRoomTypeId',
            'checkIn',
            'checkOut',
            'adults',
            'children',
            'settings'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:50',
            'guest_nic_passport' => 'nullable|string|max:50',
            'guest_address' => 'nullable|string|max:500',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1|max:20',
            'children' => 'nullable|integer|min:0|max:10',
            'payment_method' => 'required|string|in:bank_transfer,cash,card_at_desk',
            'special_requests' => 'nullable|string|max:1000',
            'addons' => 'nullable|array',
            'addons.*' => 'exists:addons,id',
        ]);

        $roomType = RoomType::findOrFail($validated['room_type_id']);

        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $nights = $checkIn->diffInDays($checkOut);
        if ($nights < 1) {
            $nights = 1;
        }

        $roomRate = $roomType->base_price_per_night;
        $roomSubtotal = $roomRate * $nights;

        // Calculate Addons
        $addonsTotal = 0;
        $selectedAddons = [];
        if (!empty($validated['addons'])) {
            $addons = Addon::whereIn('id', $validated['addons'])->get();
            foreach ($addons as $addon) {
                $qty = 1;
                if ($addon->price_type === 'per_person') {
                    $qty = $validated['adults'] + ($validated['children'] ?? 0);
                } elseif ($addon->price_type === 'per_night') {
                    $qty = $nights;
                }
                $subtotal = $addon->price * $qty;
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

        // Assign physical available room if exists
        $assignedRoom = Room::where('room_type_id', $roomType->id)
            ->where('status', 'available')
            ->first();

        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'room_type_id' => $roomType->id,
            'room_id' => $assignedRoom ? $assignedRoom->id : null,
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
            ->with('success', 'Your reservation request has been submitted successfully!');
    }

    public function confirmation(string $code): View
    {
        $booking = Booking::with(['roomType', 'room', 'addons'])->where('booking_code', $code)->firstOrFail();
        $settings = Setting::pluck('value', 'key');

        return view('public.booking.confirmation', compact('booking', 'settings'));
    }

    public function track(): View
    {
        return view('public.booking.track');
    }

    public function checkStatus(Request $request): View|RedirectResponse
    {
        $request->validate([
            'booking_code' => 'required|string',
            'phone' => 'required|string',
        ]);

        $booking = Booking::with(['roomType', 'room', 'addons'])
            ->where('booking_code', trim($request->booking_code))
            ->where('guest_phone', 'like', '%' . trim($request->phone) . '%')
            ->first();

        if (!$booking) {
            return back()->withInput()->with('error', 'No reservation found matching this Reference Number and Phone Number. Please check your details or contact resort reception.');
        }

        $settings = Setting::pluck('value', 'key');
        return view('public.booking.status_result', compact('booking', 'settings'));
    }
}
