@extends('layouts.app')

@section('title', 'Booking Confirmation - ' . $booking->booking_code . ' | New Sanda')

@section('content')
<section class="py-16 bg-stone-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Banner -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden mb-8">
            <div class="bg-brand-900 text-white p-8 text-center space-y-3">
                <div class="w-16 h-16 bg-gold-500 text-brand-900 rounded-full flex items-center justify-center text-3xl mx-auto shadow-md">
                    <i class="fa-solid fa-check"></i>
                </div>
                <h1 class="text-3xl font-serif font-bold">Reservation Request Received!</h1>
                <p class="text-sm text-slate-200 max-w-lg mx-auto">
                    Thank you, <strong>{{ $booking->guest_name }}</strong>. Your reservation request for New Sanda has been recorded.
                </p>
                <div class="inline-block bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl border border-white/20 text-gold-400 font-mono text-base font-bold">
                    Booking Code: {{ $booking->booking_code }}
                </div>
            </div>

            <!-- Booking Details Grid -->
            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 bg-slate-50 p-6 rounded-2xl border border-slate-100 text-sm">
                    <div>
                        <span class="text-xs text-slate-500 block uppercase">Check-in</span>
                        <strong class="text-slate-900">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('D, M d, Y') }}</strong>
                        <span class="text-[11px] text-slate-400 block">From 2:00 PM</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 block uppercase">Check-out</span>
                        <strong class="text-slate-900">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('D, M d, Y') }}</strong>
                        <span class="text-[11px] text-slate-400 block">Until 11:00 AM</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 block uppercase">Duration & Guests</span>
                        <strong class="text-slate-900">{{ $booking->nights }} Night(s)</strong>
                        <span class="text-[11px] text-slate-400 block">{{ $booking->adults }} Adults, {{ $booking->children }} Children</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 block uppercase">Room Category</span>
                        <strong class="text-brand-900">{{ $booking->roomType->name }}</strong>
                        @if($booking->room)
                            <span class="text-[11px] text-emerald-600 block font-semibold">Room: {{ $booking->room->room_number }}</span>
                        @endif
                    </div>
                </div>

                <!-- Financial Breakdown -->
                <div>
                    <h3 class="text-lg font-serif font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Price Breakdown</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-slate-700">
                            <span>Room Charge ({{ $booking->nights }} night(s) &times; Rs. {{ number_format($booking->room_rate) }}):</span>
                            <strong>Rs. {{ number_format($booking->room_subtotal) }}</strong>
                        </div>

                        @if($booking->addons->count() > 0)
                            @foreach($booking->addons as $addon)
                                <div class="flex justify-between text-slate-600 pl-4 border-l-2 border-brand-500">
                                    <span>{{ $addon->name }} (Qty: {{ $addon->pivot->quantity }}):</span>
                                    <span>Rs. {{ number_format($addon->pivot->subtotal) }}</span>
                                </div>
                            @endforeach
                        @endif

                        <div class="pt-4 border-t border-slate-200 flex justify-between text-base">
                            <span class="font-bold text-slate-900">Total Booking Amount:</span>
                            <span class="font-serif font-bold text-xl text-brand-900">Rs. {{ number_format($booking->total_amount) }}</span>
                        </div>

                        <div class="flex justify-between text-sm text-slate-600">
                            <span>Advance Paid:</span>
                            <span class="font-semibold text-emerald-700">Rs. {{ number_format($booking->advance_paid) }}</span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="font-bold text-slate-700">Balance Due on Arrival:</span>
                            <span class="font-bold text-rose-700">Rs. {{ number_format($booking->balance_due) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Bank Transfer Instructions -->
                <div class="bg-amber-50 border border-amber-200 p-6 rounded-2xl space-y-3">
                    <div class="flex items-center gap-2 text-amber-800 font-bold">
                        <i class="fa-solid fa-building-columns text-lg"></i>
                        <span>Advance Deposit Instructions</span>
                    </div>
                    <p class="text-xs text-amber-900 leading-relaxed">
                        To lock your room reservation, please deposit or transfer an advance (typically 30% - 50%) to our official resort bank account and share the deposit slip with your Booking Code (<strong>{{ $booking->booking_code }}</strong>) via WhatsApp:
                    </p>
                    <div class="bg-white p-4 rounded-xl border border-amber-200 font-mono text-xs text-slate-800 space-y-1">
                        <div><strong>Bank:</strong> Bank of Ceylon (BOC)</div>
                        <div><strong>Branch:</strong> Kataragama Branch</div>
                        <div><strong>Account Name:</strong> New Sanda</div>
                        <div><strong>Account Number:</strong> 8876543201</div>
                    </div>
                </div>

                <!-- Actions: Print & WhatsApp -->
                <div class="flex flex-wrap gap-4 pt-4 border-t border-slate-100">
                    <button onclick="window.print()" class="bg-slate-800 hover:bg-slate-900 text-white font-bold px-6 py-3 rounded-xl text-sm flex items-center gap-2 shadow">
                        <i class="fa-solid fa-print"></i> Print Voucher
                    </button>
                    <a href="https://wa.me/94779876543?text={{ urlencode('Hello New Sanda, I have made a reservation with code: ' . $booking->booking_code . ' for ' . $booking->guest_name . '. Please confirm.') }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3 rounded-xl text-sm flex items-center gap-2 shadow">
                        <i class="fa-brands fa-whatsapp text-lg"></i> Send Slip on WhatsApp
                    </a>
                    <a href="{{ route('booking.track') }}" class="border border-slate-300 text-slate-700 hover:bg-slate-100 font-bold px-6 py-3 rounded-xl text-sm flex items-center gap-2 ml-auto">
                        <i class="fa-solid fa-magnifying-glass"></i> Track Reservation
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
