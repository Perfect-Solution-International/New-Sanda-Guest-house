@extends('admin.layouts.app')

@section('title', 'New Walk-in / Phone Reservation - Admin')
@section('page_title', 'Create Walk-in / Phone Reservation')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
        <form action="{{ route('admin.bookings.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Guest Information -->
            <div>
                <h3 class="text-lg font-serif font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Guest Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Guest Full Name *</label>
                        <input type="text" name="guest_name" required value="{{ old('guest_name') }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Phone Number *</label>
                        <input type="text" name="guest_phone" required value="{{ old('guest_phone') }}" placeholder="+94 7X XXX XXXX" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address *</label>
                        <input type="email" name="guest_email" required value="{{ old('guest_email', 'guest@walkin.local') }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">NIC or Passport</label>
                        <input type="text" name="guest_nic_passport" value="{{ old('guest_nic_passport') }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700">
                    </div>
                </div>
            </div>

            <!-- Dates & Room Selection -->
            <div>
                <h3 class="text-lg font-serif font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Room & Dates</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Check-in Date *</label>
                        <input type="date" name="check_in_date" required value="{{ old('check_in_date', date('Y-m-d')) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Check-out Date *</label>
                        <input type="date" name="check_out_date" required value="{{ old('check_out_date', date('Y-m-d', strtotime('+1 day'))) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Room Category *</label>
                        <select name="room_type_id" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700">
                            @foreach($roomTypes as $rt)
                                <option value="{{ $rt->id }}" data-rate="{{ $rt->base_price_per_night }}">{{ $rt->name }} (Rs. {{ number_format($rt->base_price_per_night) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Assign Physical Room (Optional)</label>
                        <select name="room_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700">
                            <option value="">Assign Later</option>
                            @foreach($rooms as $r)
                                <option value="{{ $r->id }}">{{ $r->room_number }} ({{ $r->roomType->name }} - {{ ucfirst($r->status) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Adults Count</label>
                        <input type="number" name="adults" min="1" value="2" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Children Count</label>
                        <input type="number" name="children" min="0" value="0" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Agreed Room Rate (Per Night) *</label>
                        <input type="number" name="room_rate" step="0.01" value="{{ $roomTypes->first()->base_price_per_night ?? 20000 }}" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Advance Collected (Rs.)</label>
                        <input type="number" name="advance_paid" step="0.01" value="0" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-700">
                    </div>
                </div>
            </div>

            <!-- Add-ons -->
            <div>
                <h3 class="text-lg font-serif font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Tour & Package Addons</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($addons as $addon)
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 text-xs cursor-pointer hover:bg-slate-50">
                            <input type="checkbox" name="addons[]" value="{{ $addon->id }}" class="rounded text-brand-700 focus:ring-brand-700">
                            <div>
                                <strong class="text-slate-800">{{ $addon->name }}</strong>
                                <span class="text-slate-500 block">Rs. {{ number_format($addon->price) }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Status and Payment -->
            <div>
                <h3 class="text-lg font-serif font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Booking Status & Payment</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Booking Status *</label>
                        <select name="booking_status" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700">
                            <option value="confirmed" selected>Confirmed</option>
                            <option value="checked_in">Checked In Immediately</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Payment Status *</label>
                        <select name="payment_status" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700">
                            <option value="advance_paid">Advance Paid</option>
                            <option value="paid_in_full">Paid in Full</option>
                            <option value="pending" selected>Pending</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Payment Method *</label>
                        <select name="payment_method" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700">
                            <option value="cash" selected>Cash at Desk</option>
                            <option value="card_at_desk">Card (POS machine)</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Internal Notes</label>
                <textarea name="admin_notes" rows="2" placeholder="Guest preferences, ID copy taken, special arrangements..." class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-700"></textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.bookings.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-800">
                    Cancel
                </a>
                <button type="submit" class="bg-brand-700 hover:bg-brand-800 text-white font-bold px-8 py-3 rounded-xl shadow-md transition text-sm">
                    Save Reservation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
