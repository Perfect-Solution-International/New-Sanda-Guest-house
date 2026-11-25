@extends('admin.layouts.app')

@section('title', 'Edit Reservation ' . $booking->booking_code . ' - Admin')
@section('page_title', 'Edit Reservation #' . $booking->booking_code)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-xs font-bold text-slate-600 hover:text-brand-800 transition">
            &larr; Back to Reservation #{{ $booking->booking_code }}
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.bookings.invoice', $booking->id) }}" target="_blank" class="bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold px-4 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-print"></i> Print Invoice
            </a>
            <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete reservation #{{ $booking->booking_code }} ({{ addslashes($booking->guest_name) }})? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-rose-100 hover:bg-rose-200 text-rose-700 text-xs font-bold px-3.5 py-2 rounded-xl transition flex items-center gap-1.5">
                    <i class="fa-solid fa-trash"></i> Delete Reservation
                </button>
            </form>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-2xl text-xs space-y-1">
            <div class="font-bold">Please check the form for errors:</div>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            <input type="hidden" name="addons_form_present" value="1">

            <!-- 1. Guest Information -->
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                    <h3 class="text-base font-serif font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-user text-brand-700"></i> Guest Information
                    </h3>
                    <span class="font-mono text-xs font-bold text-brand-900 bg-brand-50 px-2.5 py-1 rounded-md">{{ $booking->booking_code }}</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Guest Full Name *</label>
                        <input type="text" name="guest_name" required value="{{ old('guest_name', $booking->guest_name) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Phone Number *</label>
                        <input type="text" name="guest_phone" required value="{{ old('guest_phone', $booking->guest_phone) }}" placeholder="+94 7X XXX XXXX" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address *</label>
                        <input type="email" name="guest_email" required value="{{ old('guest_email', $booking->guest_email) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">NIC or Passport</label>
                        <input type="text" name="guest_nic_passport" value="{{ old('guest_nic_passport', $booking->guest_nic_passport) }}" placeholder="e.g. 199012345678 or N1234567" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Residential Address</label>
                        <input type="text" name="guest_address" value="{{ old('guest_address', $booking->guest_address) }}" placeholder="City / Street address" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- 2. Stay Schedule & Room Assignment -->
            <div>
                <div class="border-b border-slate-100 pb-3 mb-4">
                    <h3 class="text-base font-serif font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-hotel text-brand-700"></i> Room Assignment & Schedule
                    </h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Check-in Date *</label>
                        <input type="date" name="check_in_date" id="check_in_date" required value="{{ old('check_in_date', \Carbon\Carbon::parse($booking->check_in_date)->format('Y-m-d')) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Check-out Date *</label>
                        <input type="date" name="check_out_date" id="check_out_date" required value="{{ old('check_out_date', \Carbon\Carbon::parse($booking->check_out_date)->format('Y-m-d')) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Room Category *</label>
                        <select name="room_type_id" id="room_type_select" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700 focus:outline-none">
                            @foreach($roomTypes as $rt)
                                <option value="{{ $rt->id }}" data-rate="{{ $rt->base_price_per_night }}" {{ (old('room_type_id', $booking->room_type_id) == $rt->id) ? 'selected' : '' }}>
                                    {{ $rt->name }} (Rs. {{ number_format($rt->base_price_per_night) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Physical Room Number</label>
                        <select name="room_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700 focus:outline-none">
                            <option value="">-- No Room Assigned --</option>
                            @foreach($rooms as $r)
                                <option value="{{ $r->id }}" {{ (old('room_id', $booking->room_id) == $r->id) ? 'selected' : '' }}>
                                    Room {{ $r->room_number }} ({{ $r->roomType->name ?? 'Room' }} - {{ ucfirst($r->status) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Adults Count *</label>
                        <input type="number" name="adults" min="1" value="{{ old('adults', $booking->adults) }}" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Children Count</label>
                        <input type="number" name="children" min="0" value="{{ old('children', $booking->children ?? 0) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div class="sm:col-span-2 md:col-span-3">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Agreed Room Rate (Per Night) *</label>
                        <input type="number" name="room_rate" id="room_rate_input" step="0.01" value="{{ old('room_rate', $booking->room_rate) }}" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- 3. Tour & Package Add-ons -->
            @if(isset($addons) && $addons->count() > 0)
                <div>
                    <div class="border-b border-slate-100 pb-3 mb-4">
                        <h3 class="text-base font-serif font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-compass text-brand-700"></i> Tour & Package Addons
                        </h3>
                    </div>
                    @php
                        $attachedAddonIds = $booking->addons->pluck('id')->toArray();
                    @endphp
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($addons as $addon)
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 text-xs cursor-pointer hover:bg-slate-50 transition">
                                <input type="checkbox" name="addons[]" value="{{ $addon->id }}" {{ in_array($addon->id, old('addons', $attachedAddonIds)) ? 'checked' : '' }} class="rounded text-brand-700 focus:ring-brand-700">
                                <div>
                                    <strong class="text-slate-800">{{ $addon->name }}</strong>
                                    <span class="text-slate-500 block">Rs. {{ number_format($addon->price) }} ({{ $addon->price_type == 'per_night' ? 'per night' : 'flat rate' }})</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 4. Payment & Booking Status -->
            <div>
                <div class="border-b border-slate-100 pb-3 mb-4">
                    <h3 class="text-base font-serif font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-brand-700"></i> Payment & Status
                    </h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Booking Status *</label>
                        <select name="booking_status" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700 focus:outline-none">
                            <option value="pending" {{ old('booking_status', $booking->booking_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ old('booking_status', $booking->booking_status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="checked_in" {{ old('booking_status', $booking->booking_status) == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                            <option value="checked_out" {{ old('booking_status', $booking->booking_status) == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                            <option value="cancelled" {{ old('booking_status', $booking->booking_status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Payment Status *</label>
                        <select name="payment_status" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700 focus:outline-none">
                            <option value="pending" {{ old('payment_status', $booking->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="advance_paid" {{ old('payment_status', $booking->payment_status) == 'advance_paid' ? 'selected' : '' }}>Advance Paid</option>
                            <option value="paid_in_full" {{ old('payment_status', $booking->payment_status) == 'paid_in_full' ? 'selected' : '' }}>Paid in Full</option>
                            <option value="refunded" {{ old('payment_status', $booking->payment_status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Advance Paid (Rs.) *</label>
                        <input type="number" step="0.01" name="advance_paid" required value="{{ old('advance_paid', $booking->advance_paid) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Payment Method *</label>
                        <select name="payment_method" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700 focus:outline-none">
                            <option value="cash" {{ old('payment_method', $booking->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank_transfer" {{ old('payment_method', $booking->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="card_at_desk" {{ old('payment_method', $booking->payment_method) == 'card_at_desk' ? 'selected' : '' }}>Card (POS machine)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- 5. Notes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Guest Special Requests</label>
                    <textarea name="special_requests" rows="3" placeholder="Dietary needs, extra pillows, early arrival..." class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">{{ old('special_requests', $booking->special_requests) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Internal Admin / Desk Notes</label>
                    <textarea name="admin_notes" rows="3" placeholder="Internal notes for front desk staff..." class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition">
                    &larr; Cancel and Return
                </a>
                <div class="flex items-center gap-3">
                    <button type="submit" class="bg-brand-700 hover:bg-brand-800 text-white font-bold px-8 py-3 rounded-xl shadow-md transition text-sm flex items-center gap-2">
                        <i class="fa-solid fa-check"></i> Update Reservation
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roomTypeSelect = document.getElementById('room_type_select');
        const roomRateInput = document.getElementById('room_rate_input');

        if (roomTypeSelect && roomRateInput) {
            roomTypeSelect.addEventListener('change', function () {
                const selectedOption = roomTypeSelect.options[roomTypeSelect.selectedIndex];
                const defaultRate = selectedOption.getAttribute('data-rate');
                if (defaultRate && (!roomRateInput.value || roomRateInput.value === '0')) {
                    roomRateInput.value = defaultRate;
                }
            });
        }
    });
</script>
@endsection
