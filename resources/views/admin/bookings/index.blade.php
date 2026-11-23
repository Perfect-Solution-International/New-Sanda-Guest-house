@extends('admin.layouts.app')

@section('title', 'Manage Bookings - Admin Portal')
@section('page_title', 'Reservations & Front Desk Bookings')

@section('content')
<div class="space-y-6">
    <!-- Filter and Search Header -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Search Guest / Reference</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search code, name, phone..." class="w-full text-sm border border-slate-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-brand-700">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Booking Status</label>
                <select name="status" class="w-full text-sm border border-slate-300 rounded-xl px-4 py-2 bg-white focus:ring-2 focus:ring-brand-700">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1">Payment Status</label>
                <select name="payment_status" class="w-full text-sm border border-slate-300 rounded-xl px-4 py-2 bg-white focus:ring-2 focus:ring-brand-700">
                    <option value="">All Payment States</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="advance_paid" {{ request('payment_status') == 'advance_paid' ? 'selected' : '' }}>Advance Paid</option>
                    <option value="paid_in_full" {{ request('payment_status') == 'paid_in_full' ? 'selected' : '' }}>Paid in Full</option>
                    <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-brand-700 hover:bg-brand-800 text-white font-bold py-2 rounded-xl text-xs transition">
                    <i class="fa-solid fa-filter mr-1"></i> Filter
                </button>
                <a href="{{ route('admin.bookings.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-3 py-2 rounded-xl text-xs text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Bookings Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Reference</th>
                        <th class="py-3.5 px-6">Guest Info</th>
                        <th class="py-3.5 px-6">Room Details</th>
                        <th class="py-3.5 px-6">Schedule</th>
                        <th class="py-3.5 px-6">Financials</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-4 px-6 font-mono font-bold text-brand-900 text-xs">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="hover:underline">
                                    {{ $booking->booking_code }}
                                </a>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $booking->guest_name }}</div>
                                <div class="text-xs text-slate-500">{{ $booking->guest_phone }}</div>
                                <div class="text-[11px] text-slate-400">{{ $booking->guest_email }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-slate-800 text-xs">{{ $booking->roomType->name }}</div>
                                @if($booking->room)
                                    <span class="inline-block bg-emerald-50 text-emerald-800 font-bold text-[10px] px-2 py-0.5 rounded mt-0.5">
                                        Room {{ $booking->room->room_number }}
                                    </span>
                                @else
                                    <span class="text-[10px] text-amber-600 font-semibold italic">Not Assigned</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-600">
                                <div><strong>In:</strong> {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</div>
                                <div><strong>Out:</strong> {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</div>
                                <span class="text-[10px] text-slate-400">({{ $booking->nights }} nights)</span>
                            </td>
                            <td class="py-4 px-6 text-xs">
                                <div class="font-bold text-slate-900">Total: Rs. {{ number_format($booking->total_amount) }}</div>
                                <div class="text-emerald-700">Paid: Rs. {{ number_format($booking->advance_paid) }}</div>
                                @if($booking->balance_due > 0)
                                    <div class="text-rose-600 font-bold">Due: Rs. {{ number_format($booking->balance_due) }}</div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $badge = [
                                        'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'checked_in' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                        'checked_out' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        'cancelled' => 'bg-rose-100 text-rose-800 border-rose-200',
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase border {{ $badge[$booking->booking_status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ str_replace('_', ' ', $booking->booking_status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right space-x-1">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="inline-block bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs px-3 py-1.5 rounded-lg transition">
                                    Manage
                                </a>
                                <a href="{{ route('admin.bookings.invoice', $booking->id) }}" target="_blank" title="Print Invoice" class="inline-block bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs px-2.5 py-1.5 rounded-lg transition">
                                    <i class="fa-solid fa-print"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                No reservations match your query.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
            <div class="p-6 border-t border-slate-100">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
