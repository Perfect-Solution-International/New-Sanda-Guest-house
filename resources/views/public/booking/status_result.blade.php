@extends('layouts.app')

@section('title', 'Reservation Details - ' . $booking->booking_code . ' | Sanda Guest House')

@section('content')
<section class="py-16 bg-stone-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Header status card -->
            <div class="p-8 border-b border-slate-100 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <span class="text-xs font-mono font-bold text-slate-400 uppercase">Reservation Reference</span>
                    <h1 class="text-2xl font-serif font-bold text-brand-900">{{ $booking->booking_code }}</h1>
                    <span class="text-xs text-slate-500">Booked on {{ $booking->created_at->format('M d, Y') }}</span>
                </div>

                <div class="flex items-center gap-3">
                    @php
                        $statusClasses = [
                            'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                            'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200',
                            'checked_in' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                            'checked_out' => 'bg-purple-100 text-purple-800 border-purple-200',
                            'cancelled' => 'bg-rose-100 text-rose-800 border-rose-200',
                        ];
                    @endphp
                    <span class="px-3.5 py-1.5 rounded-full text-xs font-bold uppercase border {{ $statusClasses[$booking->booking_status] ?? 'bg-slate-100 text-slate-800' }}">
                        Status: {{ str_replace('_', ' ', $booking->booking_status) }}
                    </span>
                </div>
            </div>

            <!-- Body Details -->
            <div class="p-8 space-y-8">
                <!-- Guest and Room overview -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase mb-2">Guest Details</h4>
                        <div class="text-sm font-semibold text-slate-900">{{ $booking->guest_name }}</div>
                        <div class="text-xs text-slate-600">{{ $booking->guest_phone }}</div>
                        <div class="text-xs text-slate-600">{{ $booking->guest_email }}</div>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase mb-2">Accommodation</h4>
                        <div class="text-sm font-semibold text-brand-900">{{ $booking->roomType->name }}</div>
                        <div class="text-xs text-slate-600">{{ $booking->nights }} Night(s) • {{ $booking->adults }} Adults, {{ $booking->children }} Kids</div>
                        @if($booking->room)
                            <div class="text-xs font-bold text-emerald-700 mt-1">Assigned Room: {{ $booking->room->room_number }} ({{ $booking->room->floor_wing }})</div>
                        @endif
                    </div>
                </div>

                <!-- Schedule -->
                <div class="grid grid-cols-2 gap-4 border-y border-slate-100 py-4 text-sm">
                    <div>
                        <span class="text-xs text-slate-500 block">Check-in</span>
                        <strong class="text-slate-900">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('D, M d, Y') }}</strong>
                        <span class="text-xs text-slate-400 block">02:00 PM</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 block">Check-out</span>
                        <strong class="text-slate-900">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('D, M d, Y') }}</strong>
                        <span class="text-xs text-slate-400 block">11:00 AM</span>
                    </div>
                </div>

                <!-- Financial Statement -->
                <div>
                    <h4 class="font-serif font-bold text-slate-900 mb-3">Billing & Payment</h4>
                    <div class="bg-slate-50 rounded-2xl p-6 space-y-2 text-sm border border-slate-100">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Total Booking Amount:</span>
                            <strong class="text-slate-900">Rs. {{ number_format($booking->total_amount) }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Advance Paid:</span>
                            <span class="font-bold text-emerald-700">Rs. {{ number_format($booking->advance_paid) }}</span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-slate-200">
                            <span class="font-bold text-slate-900">Balance Payable on Arrival:</span>
                            <span class="font-serif font-bold text-lg text-rose-700">Rs. {{ number_format($booking->balance_due) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-wrap gap-4 pt-4 border-t border-slate-100">
                    <a href="{{ route('booking.confirmation', $booking->booking_code) }}" class="bg-brand-700 hover:bg-brand-800 text-white font-bold px-6 py-2.5 rounded-xl text-sm shadow">
                        <i class="fa-solid fa-receipt mr-1"></i> View Full Voucher
                    </a>
                    <a href="{{ route('booking.track') }}" class="border border-slate-300 text-slate-700 hover:bg-slate-100 font-bold px-6 py-2.5 rounded-xl text-sm">
                        Track Another Reservation
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
