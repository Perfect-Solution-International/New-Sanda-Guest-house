@extends('admin.layouts.app')

@section('title', 'Reservation ' . $booking->booking_code . ' - Admin')
@section('page_title', 'Reservation Details #' . $booking->booking_code)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('admin.bookings.index') }}" class="text-xs font-bold text-slate-600 hover:text-brand-800">
            &larr; Back to Reservations List
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-pen-to-square"></i> Edit Reservation
            </a>
            <a href="{{ route('admin.bookings.invoice', $booking->id) }}" target="_blank" class="bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-print"></i> Print Official Invoice
            </a>
            <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete reservation #{{ $booking->booking_code }} ({{ addslashes($booking->guest_name) }})?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-rose-100 hover:bg-rose-200 text-rose-700 text-xs font-bold px-3 py-2 rounded-xl transition flex items-center gap-1.5">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Booking Overview Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Booking Info & Financials -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Guest & Dates -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-serif font-bold text-lg text-slate-900">Guest Information</h3>
                    <span class="font-mono text-xs font-bold text-brand-900 bg-brand-50 px-2.5 py-1 rounded-md">{{ $booking->booking_code }}</span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-xs text-slate-400 block uppercase">Full Name</span>
                        <strong class="text-slate-900">{{ $booking->guest_name }}</strong>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block uppercase">Phone Number</span>
                        <strong class="text-brand-800">{{ $booking->guest_phone }}</strong>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block uppercase">Email</span>
                        <span class="text-slate-700">{{ $booking->guest_email }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block uppercase">NIC / Passport</span>
                        <span class="text-slate-700">{{ $booking->guest_nic_passport ?? 'Not provided' }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-xs text-slate-400 block uppercase">Residential Address</span>
                        <span class="text-slate-700">{{ $booking->guest_address ?? 'Not specified' }}</span>
                    </div>
                </div>
            </div>

            <!-- Stay Schedule -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 space-y-4">
                <h3 class="font-serif font-bold text-lg text-slate-900 border-b border-slate-100 pb-3">Stay Schedule</h3>
                <div class="grid grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="text-xs text-slate-400 block uppercase">Check-in Date</span>
                        <strong class="text-slate-900">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('D, M d, Y') }}</strong>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block uppercase">Check-out Date</span>
                        <strong class="text-slate-900">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('D, M d, Y') }}</strong>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block uppercase">Total Nights</span>
                        <strong class="text-brand-900">{{ $booking->nights }} Night(s)</strong>
                    </div>
                </div>

                @if($booking->special_requests)
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-xs text-slate-700">
                        <strong class="text-slate-900 block mb-1">Guest Special Requests:</strong>
                        {{ $booking->special_requests }}
                    </div>
                @endif
            </div>

            <!-- Billing Breakdown -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 space-y-4">
                <h3 class="font-serif font-bold text-lg text-slate-900 border-b border-slate-100 pb-3">Billing & Addons</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>Room Rate ({{ $booking->nights }} night(s) &times; Rs. {{ number_format($booking->room_rate) }}):</span>
                        <strong>Rs. {{ number_format($booking->room_subtotal) }}</strong>
                    </div>
                    @foreach($booking->addons as $addon)
                        <div class="flex justify-between text-slate-600 pl-4 border-l-2 border-brand-500">
                            <span>{{ $addon->name }} (Qty: {{ $addon->pivot->quantity }}):</span>
                            <span>Rs. {{ number_format($addon->pivot->subtotal) }}</span>
                        </div>
                    @endforeach
                    <div class="pt-3 border-t border-slate-200 flex justify-between font-bold text-base text-slate-900">
                        <span>Total Invoice Amount:</span>
                        <span class="text-brand-900 font-serif text-xl">Rs. {{ number_format($booking->total_amount) }}</span>
                    </div>
                    <div class="flex justify-between text-emerald-700 font-bold">
                        <span>Advance Paid:</span>
                        <span>Rs. {{ number_format($booking->advance_paid) }}</span>
                    </div>
                    <div class="flex justify-between text-rose-700 font-bold text-base pt-1 border-t border-dashed border-slate-200">
                        <span>Balance Due:</span>
                        <span>Rs. {{ number_format($booking->balance_due) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Status Updater & Physical Room Assignment -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 space-y-6">
                <h3 class="font-serif font-bold text-lg text-slate-900 border-b border-slate-100 pb-3">Reservation Status</h3>

                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Booking Status</label>
                        <select name="booking_status" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700">
                            <option value="pending" {{ $booking->booking_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->booking_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="checked_in" {{ $booking->booking_status == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                            <option value="checked_out" {{ $booking->booking_status == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                            <option value="cancelled" {{ $booking->booking_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Assigned Physical Room</label>
                        <select name="room_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700">
                            <option value="">-- No Room Assigned --</option>
                            @foreach($rooms as $r)
                                <option value="{{ $r->id }}" {{ $booking->room_id == $r->id ? 'selected' : '' }}>
                                    Room {{ $r->room_number }} ({{ $r->floor_wing }} - {{ ucfirst($r->status) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Payment Status</label>
                        <select name="payment_status" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-brand-700">
                            <option value="pending" {{ $booking->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="advance_paid" {{ $booking->payment_status == 'advance_paid' ? 'selected' : '' }}>Advance Paid</option>
                            <option value="paid_in_full" {{ $booking->payment_status == 'paid_in_full' ? 'selected' : '' }}>Paid in Full</option>
                            <option value="refunded" {{ $booking->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Advance Amount Received (Rs.)</label>
                        <input type="number" step="0.01" name="advance_paid" value="{{ $booking->advance_paid }}" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-brand-700">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Payment Method</label>
                        <select name="payment_method" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm bg-white focus:ring-2 focus:ring-brand-700">
                            <option value="cash" {{ $booking->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank_transfer" {{ $booking->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="card_at_desk" {{ $booking->payment_method == 'card_at_desk' ? 'selected' : '' }}>Credit / Debit Card</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Desk Notes</label>
                        <textarea name="admin_notes" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-xs focus:ring-2 focus:ring-brand-700" placeholder="Notes for front desk staff...">{{ $booking->admin_notes }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-brand-700 hover:bg-brand-800 text-white font-bold py-3 rounded-xl shadow transition text-sm">
                        Update Reservation
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
