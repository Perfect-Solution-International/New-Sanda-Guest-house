@extends('admin.layouts.app')

@section('title', 'Create New Reservation - Sanda Guest House')
@section('page_title', 'New Walk-in / Phone Reservation')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-300 text-rose-800 p-4 rounded-2xl text-sm flex items-start gap-3 shadow-xs">
            <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg mt-0.5"></i>
            <div>
                <strong class="font-bold block">Reservation Conflict:</strong>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
        <form action="{{ route('admin.bookings.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Guest Information -->
            <div>
                <h3 class="text-base font-serif font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-user text-brand-700"></i> Guest Contact Details
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Guest Full Name *</label>
                        <input type="text" name="guest_name" required value="{{ old('guest_name') }}" placeholder="e.g. Ruwan Perera"
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            <i class="fa-brands fa-whatsapp text-emerald-600 mr-1"></i> Phone / WhatsApp Number *
                        </label>
                        <input type="text" name="guest_phone" required value="{{ old('guest_phone') }}" placeholder="+94 7X XXX XXXX"
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address (Optional)</label>
                        <input type="email" name="guest_email" value="{{ old('guest_email') }}" placeholder="guest@sandaguesthouse.lk"
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">NIC or Passport</label>
                        <input type="text" name="guest_nic_passport" value="{{ old('guest_nic_passport') }}" placeholder="National ID / Passport"
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Residential Address</label>
                        <input type="text" name="guest_address" value="{{ old('guest_address') }}" placeholder="City / Street address"
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- Dates, Exact Time & Room Selection -->
            <div>
                <h3 class="text-base font-serif font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-hotel text-brand-700"></i> Dates, Exact Times & Room Assignment
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Check-in Date *</label>
                        <input type="date" name="check_in_date" required value="{{ old('check_in_date', $defaultCheckIn) }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Check-in Time *</label>
                        <input type="time" name="check_in_time" required value="{{ old('check_in_time', $defaultCheckInTime) }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Check-out Date *</label>
                        <input type="date" name="check_out_date" required value="{{ old('check_out_date', $defaultCheckOut) }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Check-out Time *</label>
                        <input type="time" name="check_out_time" required value="{{ old('check_out_time', $defaultCheckOutTime) }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Room Category *</label>
                        <select name="room_type_id" id="admin_room_type" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700 focus:outline-none">
                            @foreach($roomTypes as $rt)
                                <option value="{{ $rt->id }}" data-rate="{{ $rt->base_price_per_night }}" {{ old('room_type_id') == $rt->id ? 'selected' : '' }}>
                                    {{ $rt->name }} (Rs. {{ number_format($rt->base_price_per_night) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Assign Physical Room (Overlap Protected)</label>
                        <select name="room_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700 focus:outline-none">
                            <option value="">-- Assign Later / Auto --</option>
                            @foreach($rooms as $r)
                                <option value="{{ $r->id }}" {{ old('room_id') == $r->id ? 'selected' : '' }}>
                                    Room {{ $r->room_number }} ({{ $r->roomType->name ?? 'Room' }} - {{ ucfirst($r->status) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Adults Count *</label>
                        <input type="number" name="adults" min="1" value="{{ old('adults', 2) }}" required
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Children Count</label>
                        <input type="number" name="children" min="0" value="{{ old('children', 0) }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Room Rate *</label>
                        <input type="number" name="room_rate" id="admin_room_rate" step="0.01" value="{{ old('room_rate', $roomTypes->first()->base_price_per_night ?? 5500) }}" required
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- Add-ons -->
            @if(isset($addons) && $addons->count() > 0)
                <div>
                    <h3 class="text-base font-serif font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2 flex items-center gap-2">
                        <i class="fa-solid fa-compass text-brand-700"></i> Tour & Package Addons
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($addons as $addon)
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 text-xs cursor-pointer hover:bg-slate-50">
                                <input type="checkbox" name="addons[]" value="{{ $addon->id }}" {{ in_array($addon->id, old('addons', [])) ? 'checked' : '' }}
                                       class="rounded text-brand-700 focus:ring-brand-700">
                                <div>
                                    <strong class="text-slate-800">{{ $addon->name }}</strong>
                                    <span class="text-slate-500 block">Rs. {{ number_format($addon->price) }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Status and Payment -->
            <div>
                <h3 class="text-base font-serif font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-brand-700"></i> Booking Status & Payment
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Booking Status *</label>
                        <select name="booking_status" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700 focus:outline-none">
                            <option value="confirmed" selected>Confirmed</option>
                            <option value="checked_in">Checked In</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Payment Status *</label>
                        <select name="payment_status" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700 focus:outline-none">
                            <option value="advance_paid">Advance Paid</option>
                            <option value="paid_in_full">Paid in Full</option>
                            <option value="pending" selected>Pending</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Advance Collected (Rs.)</label>
                        <input type="number" name="advance_paid" step="0.01" value="{{ old('advance_paid', 0) }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Payment Method *</label>
                        <select name="payment_method" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700 focus:outline-none">
                            <option value="cash" selected>Cash at Desk</option>
                            <option value="card_at_desk">Card (POS machine)</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Guest Special Requests</label>
                    <textarea name="special_requests" rows="2" placeholder="Dietary needs, extra bed..." class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">{{ old('special_requests') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Internal Front Desk Notes</label>
                    <textarea name="admin_notes" rows="2" placeholder="Guest ID copy taken, advance verified..." class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">{{ old('admin_notes') }}</textarea>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.bookings.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-800">
                    &larr; Cancel
                </a>
                <button type="submit" class="bg-brand-700 hover:bg-brand-800 text-white font-bold px-8 py-3 rounded-xl shadow-md transition text-sm flex items-center gap-2">
                    <i class="fa-solid fa-check"></i> Save & Lock Reservation
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roomTypeSelect = document.getElementById('admin_room_type');
        const roomRateInput = document.getElementById('admin_room_rate');

        if (roomTypeSelect && roomRateInput) {
            roomTypeSelect.addEventListener('change', function () {
                const selectedOption = roomTypeSelect.options[roomTypeSelect.selectedIndex];
                const defaultRate = selectedOption.getAttribute('data-rate');
                if (defaultRate) {
                    roomRateInput.value = defaultRate;
                }
            });
        }
    });
</script>
@endsection
