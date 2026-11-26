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

            <!-- Alerts / Notifications -->
            @if(session('error'))
                <div class="mb-6 bg-rose-50 border border-rose-300 text-rose-900 px-5 py-4 rounded-2xl text-xs sm:text-sm flex items-start gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-base mt-0.5 flex-shrink-0"></i>
                    <div>
                        <strong class="font-bold block">Reservation Lookup Notice:</strong>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-300 text-emerald-900 px-5 py-4 rounded-2xl text-xs sm:text-sm flex items-start gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base mt-0.5 flex-shrink-0"></i>
                    <div>
                        <strong class="font-bold block">Success:</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-rose-50 border border-rose-300 text-rose-900 px-5 py-4 rounded-2xl text-xs sm:text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('booking.track.check') }}" method="POST" class="space-y-5" 
                  x-data="{ code: '{{ old('booking_code', $prefillCode ?? '') }}', phone: '{{ old('phone', $prefillPhone ?? '') }}' }"
                  @submit="if(!code.trim() && !phone.trim()){ alert('Please enter your Booking Reference Number or Phone Number. (කරුණාකර Reference අංකය හෝ දුරකථන අංකය ඇතුළත් කරන්න)'); $event.preventDefault(); }">
                @csrf

                <!-- Option 1: Booking Reference Number -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                            <i class="fa-solid fa-ticket text-brand-700 mr-1"></i> Booking Reference Number
                        </label>
                        <span class="text-[10px] bg-brand-50 text-brand-800 font-semibold px-2 py-0.5 rounded-md">Fastest Option</span>
                    </div>
                    <input type="text" name="booking_code" x-model="code" placeholder="e.g. NS-2026-XXXX or 49311B" 
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm font-mono uppercase tracking-wider focus:ring-2 focus:ring-brand-700 focus:border-brand-700 focus:outline-none transition">
                    <span class="text-[11px] text-slate-500 mt-1.5 flex items-center gap-1">
                        <i class="fa-solid fa-circle-info text-slate-400"></i>
                        <span>Enter full code (e.g. <strong>NS-2026-XXXX</strong>) or just code suffix (e.g. <strong>XXXX</strong>)</span>
                    </span>
                </div>

                <!-- Divider: OR -->
                <div class="relative flex items-center py-1">
                    <div class="flex-grow border-t border-slate-200"></div>
                    <span class="flex-shrink mx-3 text-slate-400 text-xs font-bold uppercase tracking-wider bg-white px-2 py-0.5 rounded border border-slate-100">
                        OR / හෝ
                    </span>
                    <div class="flex-grow border-t border-slate-200"></div>
                </div>

                <!-- Option 2: Guest Phone or WhatsApp Number -->
                <div>
                    <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">
                        <i class="fa-brands fa-whatsapp text-emerald-600 mr-1"></i> Registered Phone or WhatsApp Number
                    </label>
                    <input type="text" name="phone" x-model="phone" placeholder="e.g. 077 123 4567 or +94 77..." 
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand-700 focus:border-brand-700 focus:outline-none transition">
                    <span class="text-[11px] text-slate-500 mt-1.5 flex items-center gap-1">
                        <i class="fa-solid fa-circle-info text-slate-400"></i>
                        <span>Mobile number used when making the reservation</span>
                    </span>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-brand-800 hover:bg-brand-900 text-white font-bold py-3.5 rounded-xl shadow-md hover:shadow-lg transition text-sm flex items-center justify-center gap-2 group cursor-pointer">
                        <i class="fa-solid fa-magnifying-glass text-gold-400 group-hover:scale-110 transition-transform"></i>
                        <span>Access Guest Portal & Details</span>
                    </button>
                    <p class="text-[11px] text-center text-slate-400 mt-2">
                        ඔබගේ Reference Number එක හෝ දුරකථන අංකය ලබාදී තොරතුරු බලාගත හැක.
                    </p>
                </div>
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
