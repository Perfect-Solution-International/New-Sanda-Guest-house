@extends('layouts.app')

@section('title', 'Guest Self-Service Portal & Reservation Status - Sanda Guest House')

@section('content')
<section class="py-16 bg-brand-900 text-white text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#d99726_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-4xl mx-auto px-4 relative z-10">
        <span class="inline-block bg-gold-400/20 text-gold-400 border border-gold-400/30 px-3 py-1 rounded-full font-bold text-xs uppercase tracking-widest mb-3">
            Guest Self-Service Portal
        </span>
        <h1 class="text-3xl sm:text-4xl font-serif font-bold text-white mb-3">Manage Your Reservation</h1>
        <p class="text-slate-200 text-sm max-w-xl mx-auto font-light">
            Enter your booking reference number and registered phone number to view stay details, request special arrangements, or cancel your booking.
        </p>
    </div>
</section>

<section class="py-16 bg-[#fcfaf7]">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-sm border border-slate-200">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-brand-50 text-brand-800 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-hotel"></i>
                </div>
                <div>
                    <h3 class="font-serif font-bold text-slate-900 text-base">Find Your Stay</h3>
                    <p class="text-xs text-slate-500">Instant access to your booking confirmation</p>
                </div>
            </div>

            <form action="{{ route('booking.track.check') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Booking Reference Number *
                    </label>
                    <input type="text" name="booking_code" value="{{ old('booking_code', $prefillCode ?? '') }}" required placeholder="e.g. NS-2026-XXXX" 
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm font-mono uppercase tracking-wider focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Sent upon booking submission (e.g. NS-2026-XXXX)</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        <i class="fa-brands fa-whatsapp text-emerald-600 mr-1"></i> Guest Phone or WhatsApp Number *
                    </label>
                    <input type="text" name="phone" value="{{ old('phone', $prefillPhone ?? '') }}" required placeholder="Phone number entered during booking" 
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">The mobile number used when making the reservation</span>
                </div>

                <button type="submit" class="w-full bg-brand-800 hover:bg-brand-900 text-white font-bold py-3.5 rounded-xl shadow-md transition text-sm flex items-center justify-center gap-2 group">
                    <i class="fa-solid fa-magnifying-glass text-gold-400 group-hover:scale-110 transition-transform"></i> Access Guest Portal
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
                <div>
                    <span class="text-xs text-slate-500 block">Need immediate assistance?</span>
                    <a href="tel:+94779876543" class="text-xs font-bold text-brand-700 hover:underline">
                        Call Front Desk: 077 987 6543
                    </a>
                </div>
                <a href="https://wa.me/94779876543" target="_blank" class="text-xs bg-emerald-50 text-emerald-700 font-bold px-3 py-1.5 rounded-xl hover:bg-emerald-100 transition flex items-center gap-1.5">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp Concierge
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
