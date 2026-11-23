@extends('admin.layouts.app')

@section('title', 'Edit Reservation ' . $booking->booking_code)
@section('page_title', 'Edit Reservation')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <h3 class="text-lg font-serif font-bold text-slate-900 mb-2">Modify Reservation Details</h3>
            <p class="text-xs text-slate-500">Update status, payment records, and room assignment for {{ $booking->booking_code }}.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Booking Status</label>
                <select name="booking_status" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white">
                    <option value="pending" {{ $booking->booking_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $booking->booking_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="checked_in" {{ $booking->booking_status == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="checked_out" {{ $booking->booking_status == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                    <option value="cancelled" {{ $booking->booking_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Assigned Room</label>
                <select name="room_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white">
                    <option value="">None</option>
                    @foreach($rooms as $r)
                        <option value="{{ $r->id }}" {{ $booking->room_id == $r->id ? 'selected' : '' }}>{{ $r->room_number }} ({{ $r->floor_wing }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Advance Paid</label>
                <input type="number" step="0.01" name="advance_paid" value="{{ $booking->advance_paid }}" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Payment Status</label>
                <select name="payment_status" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white">
                    <option value="pending" {{ $booking->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="advance_paid" {{ $booking->payment_status == 'advance_paid' ? 'selected' : '' }}>Advance Paid</option>
                    <option value="paid_in_full" {{ $booking->payment_status == 'paid_in_full' ? 'selected' : '' }}>Paid in Full</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Payment Method</label>
                <select name="payment_method" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm bg-white">
                    <option value="cash" {{ $booking->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="bank_transfer" {{ $booking->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="card_at_desk" {{ $booking->payment_method == 'card_at_desk' ? 'selected' : '' }}>Card</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Admin Notes</label>
            <textarea name="admin_notes" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm">{{ $booking->admin_notes }}</textarea>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-xs font-bold text-slate-500">Cancel</a>
            <button type="submit" class="bg-brand-700 text-white font-bold px-6 py-2.5 rounded-xl text-sm">Update</button>
        </div>
    </form>
</div>
@endsection
