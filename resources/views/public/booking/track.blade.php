@extends('layouts.app')

@section('title', 'Track Booking Status - Nivi Sanda Family Holiday Resort')

@section('content')
<section class="py-16 bg-brand-900 text-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-gold-400 font-bold text-xs uppercase tracking-widest block mb-2">Guest Self-Service</span>
        <h1 class="text-3xl sm:text-4xl font-serif font-bold text-white mb-2">Check Your Reservation Status</h1>
        <p class="text-slate-200 text-sm max-w-xl mx-auto font-light">
            Enter your booking reference number and registered phone number to view your stay details.
        </p>
    </div>
</section>

<section class="py-16 bg-stone-50">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-sm border border-slate-200">
            <form action="{{ route('booking.track.check') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Booking Reference Number *
                    </label>
                    <input type="text" name="booking_code" value="{{ old('booking_code') }}" required placeholder="e.g. NS-2026-A101" class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm font-mono uppercase focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Provided upon confirmation (e.g. NS-2026-XXXX)</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Guest Mobile Phone Number *
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="Phone number used during booking" class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>

                <button type="submit" class="w-full bg-brand-700 hover:bg-brand-800 text-white font-bold py-3.5 rounded-xl shadow-md transition text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-magnifying-glass text-gold-400"></i> Find My Reservation
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <span class="text-xs text-slate-500 block mb-2">Can't locate your booking reference?</span>
                <a href="tel:+94779876543" class="text-xs font-bold text-brand-700 hover:underline">
                    Call Resort Reception: +94 77 987 6543
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
